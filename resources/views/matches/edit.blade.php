<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Skor Pertandingan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl overflow-hidden">
                <div class="p-5 sm:p-6">
                    <form action="{{ route('matches.update', $match) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Match Info -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                {{ $match->session->session_date->format('d M Y') }} - Lapangan {{ $match->court_no }}
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Team 1 -->
                                <div class="text-center">
                                    <h4 class="text-lg font-semibold text-blue-600 mb-4">Team 1</h4>
                                    <div class="space-y-2">
                                        @foreach($team1Players as $player)
                                            <div class="p-3 bg-blue-50 rounded-xl">
                                                <div class="font-medium">{{ $player->player->name }}</div>
                                                <div class="text-sm text-gray-600">Grade {{ $player->player->grade }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Team 2 -->
                                <div class="text-center">
                                    <h4 class="text-lg font-semibold text-red-600 mb-4">Team 2</h4>
                                    <div class="space-y-2">
                                        @foreach($team2Players as $player)
                                            <div class="p-3 bg-red-50 rounded-xl">
                                                <div class="font-medium">{{ $player->player->name }}</div>
                                                <div class="text-sm text-gray-600">Grade {{ $player->player->grade }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Score Input -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="team1_score" class="block text-sm font-medium text-gray-700">
                                    Skor Team 1 <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       id="team1_score" 
                                       name="team1_score" 
                                       value="{{ old('team1_score') }}"
                                       min="0"
                                       class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-center text-2xl font-bold"
                                       required>
                            </div>

                            <div>
                                <label for="team2_score" class="block text-sm font-medium text-gray-700">
                                    Skor Team 2 <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       id="team2_score" 
                                       name="team2_score" 
                                       value="{{ old('team2_score') }}"
                                       min="0"
                                       class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border text-center text-2xl font-bold"
                                       required>
                            </div>
                        </div>

                        <!-- Auto Winner Info -->
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-blue-800">
                                    <strong>Pemenang akan ditentukan otomatis</strong> berdasarkan skor tertinggi. 
                                    Jika skor sama, pertandingan akan dianggap seri.
                                </span>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">
                                Catatan
                            </label>
                            <textarea id="notes" 
                                      name="notes" 
                                      rows="3"
                                      class="mt-1 block w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border"
                                      placeholder="Catatan pertandingan...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('matches.show', $match) }}" 
                               class="px-4 py-2.5 border border-gray-200 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Simpan Skor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
