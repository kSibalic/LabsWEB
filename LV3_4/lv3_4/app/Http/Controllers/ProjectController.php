<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('projects.index', [
            'moji_projekti' => $user->projectsVoditelj,
            'projekti_clan' => $user->projectsClan
        ]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'naziv' => 'required',
            'opis' => 'nullable',
            'cijena' => 'nullable|numeric|min:0',
            'datum_pocetka' => 'nullable|date',
            'datum_zavrsetka' => 'nullable|date'
        ]);

        $data['user_id'] = auth()->id();

        $project = Project::create($data);

        // Automatski dodaj voditelja kao člana tima
        $project->clanovi()->attach(auth()->id());

        return redirect()->route('projects.index');
    }

    public function edit(Project $project)
    {
        // Provjeri da li korisnik ima pristup projektu (voditelj ili član)
        $isVoditelj = $this->isVoditelj($project);
        $isClan = $project->clanovi->contains(auth()->id());

        if (!$isVoditelj && !$isClan) {
            abort(403, "Nemaš pravo pristupa ovom projektu.");
        }

        $users = User::all();

        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        if ($this->isVoditelj($project)) {
            // voditelj može sve
            $data = $request->validate([
                'naziv' => 'required',
                'opis' => 'nullable',
                'cijena' => 'nullable|numeric|min:0',
                'obavljeni_poslovi' => 'nullable',
                'datum_pocetka' => 'nullable|date',
                'datum_zavrsetka' => 'nullable|date',
                'clanovi' => 'nullable|array'
            ]);

            $project->update($data);

            // Sinkroniziraj članove
            if ($request->has('clanovi')) {
                $project->clanovi()->sync($request->clanovi);
            } else {
                $project->clanovi()->sync([]);
            }

        } else {
            // član tima može samo obavljeni_poslovi
            $data = $request->validate([
                'obavljeni_poslovi' => 'nullable'
            ]);

            $project->update($data);
        }
        return redirect()->route('projects.index', $project);
    }

    private function isVoditelj(Project $project)
    {
        return auth()->id() === $project->user_id;
    }

    private function authorizeVoditelj(Project $project)
    {
        if (!$this->isVoditelj($project)) {
            abort(403, "Nemaš pravo pristupa.");
        }
    }
}
