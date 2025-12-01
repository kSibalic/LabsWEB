<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->isNastavnik()) {
            $tasks = auth()->user()->taskovi()->with('prijavljeniStudenti')->get();
            return view('tasks.index', compact('tasks'));
        }

        if (auth()->user()->isStudent()) {
            $tasks = Task::whereNull('prihvaceni_student_id')->with('nastavnik')->get();
            $myApplications = auth()->user()->prijave()->pluck('task_id')->toArray();
            return view('tasks.student-index', compact('tasks', 'myApplications'));
        }

        abort(403);
    }

    public function create()
    {
        if (!auth()->user()->isNastavnik()) {
            abort(403);
        }

        return view('tasks.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isNastavnik()) {
            abort(403);
        }

        $validated = $request->validate([
            'naziv_rada' => 'required|string|max:255',
            'naziv_rada_en' => 'required|string|max:255',
            'zadatak_rada' => 'required|string',
            'zadatak_rada_en' => 'required|string',
            'tip_studija' => 'required|in:stručni,preddiplomski,diplomski',
        ]);

        $validated['nastavnik_id'] = auth()->id();

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Rad uspješno dodan!');
    }

    public function edit(Task $task)
    {
        if (!auth()->user()->isNastavnik() || $task->nastavnik_id !== auth()->id()) {
            abort(403);
        }

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if (!auth()->user()->isNastavnik() || $task->nastavnik_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'naziv_rada' => 'required|string|max:255',
            'naziv_rada_en' => 'required|string|max:255',
            'zadatak_rada' => 'required|string',
            'zadatak_rada_en' => 'required|string',
            'tip_studija' => 'required|in:stručni,preddiplomski,diplomski',
        ]);
        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Rad uspješno ažuriran!');
    }

    public function destroy(Task $task)
    {
        if (!auth()->user()->isNastavnik() || $task->nastavnik_id !== auth()->id()) {
            abort(403);
        }
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Rad uspješno obrisan!');
    }

    public function apply(Request $request, Task $task)
    {
        if (!auth()->user()->isStudent()) {
            abort(403);
        }
        $currentApplications = auth()->user()->prijave()->count();

        if ($currentApplications >= 5) {
            return redirect()->back()->with('error', 'Možete se prijaviti maksimalno na 5 radova!');
        }
        $prioritet = $request->input('prioritet', $currentApplications + 1);

        try {
            auth()->user()->prijave()->attach($task->id, ['prioritet' => $prioritet]);
            return redirect()->back()->with('success', 'Uspješno ste se prijavili na rad!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Već ste prijavljeni na ovaj rad!');
        }
    }

    public function acceptStudent(Task $task, $studentId)
    {
        if (!auth()->user()->isNastavnik() || $task->nastavnik_id !== auth()->id()) {
            abort(403);
        }
        $application = $task->prijavljeniStudenti()->where('student_id', $studentId)->first();

        if ($application && $application->pivot->prioritet != 1) {
            return redirect()->back()->with('error', 'Možete prihvatiti samo studenta kod kojeg je ovaj rad prioritet 1!');
        }
        $task->update(['prihvaceni_student_id' => $studentId]);

        return redirect()->back()->with('success', 'Student uspješno prihvaćen!');
    }
}
