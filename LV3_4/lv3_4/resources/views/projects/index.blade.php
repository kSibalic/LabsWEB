<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projekti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Moji projekti (voditelj) -->
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold text-gray-800 mb-4">Moji projekti (voditelj)</h1>
                        @forelse($moji_projekti as $proj)
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-3 hover:bg-gray-100 transition">
                                <span class="text-lg font-semibold text-gray-700">{{ $proj->naziv }}</span>
                                <span class="mx-2 text-gray-400">–</span>
                                <a href="{{ route('projects.edit', $proj) }}"
                                   class="text-blue-600 hover:text-blue-800 underline">
                                    Uredi
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">Nemate projekata kao voditelj.</p>
                        @endforelse
                    </div>

                    <!-- Projekti član -->
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold text-gray-800 mb-4">Projekti član</h1>
                        @forelse($projekti_clan as $proj)
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-3 hover:bg-gray-100 transition">
                                <span class="text-lg font-semibold text-gray-700">{{ $proj->naziv }}</span>
                                <span class="mx-2 text-gray-400">–</span>
                                <a href="{{ route('projects.edit', $proj) }}"
                                   class="text-blue-600 hover:text-blue-800 underline">
                                    Uredi
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">Niste član niti jednog projekta.</p>
                        @endforelse
                    </div>

                    <!-- Novi projekt button -->
                    <div class="mt-6">
                        <a href="{{ route('projects.create') }}"
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-200">
                            + Novi projekt
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
