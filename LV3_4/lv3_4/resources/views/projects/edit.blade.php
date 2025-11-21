<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Uredi projekt') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Informacije o projektu -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(auth()->id() === $project->user_id)
                        <!-- VODITELJ VIEW -->
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Uredi projekt</h2>

                        <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="naziv" class="block text-sm font-medium text-gray-700 mb-2">
                                    Naziv projekta *
                                </label>
                                <input
                                    type="text"
                                    name="naziv"
                                    id="naziv"
                                    value="{{ $project->naziv }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                            </div>

                            <div>
                                <label for="opis" class="block text-sm font-medium text-gray-700 mb-2">
                                    Opis projekta
                                </label>
                                <textarea
                                    name="opis"
                                    id="opis"
                                    rows="5"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $project->opis }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="datum_pocetka" class="block text-sm font-medium text-gray-700 mb-2">
                                        Datum početka
                                    </label>
                                    <input
                                        type="date"
                                        name="datum_pocetka"
                                        id="datum_pocetka"
                                        value="{{ $project->datum_pocetka }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="datum_zavrsetka" class="block text-sm font-medium text-gray-700 mb-2">
                                        Datum završetka
                                    </label>
                                    <input
                                        type="date"
                                        name="datum_zavrsetka"
                                        id="datum_zavrsetka"
                                        value="{{ $project->datum_zavrsetka }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Članovi tima</h3>
                                <div class="space-y-2 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    @foreach($users as $u)
                                        <label class="flex items-center hover:bg-gray-100 p-2 rounded transition cursor-pointer">
                                            <input
                                                type="checkbox"
                                                name="clanovi[]"
                                                value="{{ $u->id }}"
                                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                @if($project->clanovi->contains($u)) checked @endif
                                                @if($u->id === $project->user_id) disabled @endif>
                                            <span class="ml-3 text-gray-700">
                                                {{ $u->name }}
                                                @if($u->id === $project->user_id)
                                                    <span class="text-xs text-blue-600 font-semibold">(voditelj)</span>
                                                @endif
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label for="obavljeni_poslovi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Obavljeni poslovi / Zadaci
                                    <span class="text-xs text-gray-500">(svaki zadatak u novom redu)</span>
                                </label>
                                <textarea
                                    name="obavljeni_poslovi"
                                    id="obavljeni_poslovi"
                                    rows="8"
                                    placeholder="- Postavljanje baze podataka&#10;- Kreiranje modela&#10;- Implementacija autentikacije&#10;..."
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm">{{ $project->obavljeni_poslovi }}</textarea>
                            </div>

                            <div class="flex gap-4">
                                <button
                                    type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-200">
                                    Spremi izmjene
                                </button>
                                <a
                                    href="{{ route('projects.index') }}"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition duration-200">
                                    Odustani
                                </a>
                            </div>
                        </form>

                    @else
                        <!-- ČLAN TIMA VIEW -->
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $project->naziv }}</h2>

                        <!-- Prikaz informacija (read-only) -->
                        <div class="space-y-4 mb-8 bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 mb-1">Opis projekta</h3>
                                <p class="text-gray-800">{{ $project->opis ?? 'Nema opisa' }}</p>
                            </div>

                            @if($project->datum_pocetka || $project->datum_zavrsetka)
                                <div class="grid grid-cols-2 gap-4">
                                    @if($project->datum_pocetka)
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-600 mb-1">Datum početka</h3>
                                            <p class="text-gray-800">{{ \Carbon\Carbon::parse($project->datum_pocetka)->format('d.m.Y') }}</p>
                                        </div>
                                    @endif

                                    @if($project->datum_zavrsetka)
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-600 mb-1">Datum završetka</h3>
                                            <p class="text-gray-800">{{ \Carbon\Carbon::parse($project->datum_zavrsetka)->format('d.m.Y') }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 mb-2">Članovi tima</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($project->clanovi as $clan)
                                        <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                            {{ $clan->name }}
                                            @if($clan->id === $project->user_id)
                                                <span class="text-xs font-semibold">(voditelj)</span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Forma za uređivanje obavljenih poslova -->
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Ažuriraj obavljene poslove</h3>
                        <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="obavljeni_poslovi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Obavljeni poslovi / Zadaci
                                    <span class="text-xs text-gray-500">(svaki zadatak u novom redu)</span>
                                </label>
                                <textarea
                                    name="obavljeni_poslovi"
                                    id="obavljeni_poslovi"
                                    rows="10"
                                    placeholder="Dodaj što si obavio/obavila..."
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm">{{ $project->obavljeni_poslovi }}</textarea>
                            </div>

                            <div class="flex gap-4">
                                <button
                                    type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-200">
                                    Spremi
                                </button>
                                <a
                                    href="{{ route('projects.index') }}"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition duration-200">
                                    Odustani
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
