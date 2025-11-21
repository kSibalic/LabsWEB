<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novi projekt') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="naziv" class="block text-sm font-medium text-gray-700 mb-2">
                                Naziv projekta *
                            </label>
                            <input
                                type="text"
                                name="naziv"
                                id="naziv"
                                placeholder="Unesite naziv projekta"
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
                                placeholder="Opišite projekt..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                        </div>

                        <div>
                            <label for="cijena" class="block text-sm font-medium text-gray-700 mb-2">
                                Cijena projekta (€)
                            </label>
                            <input
                                type="number"
                                step="1"
                                min="0"
                                name="cijena"
                                id="cijena"
                                placeholder="0.00"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
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
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-200">
                                Kreiraj projekt
                            </button>
                            <a
                                href="{{ route('projects.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition duration-200">
                                Odustani
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
