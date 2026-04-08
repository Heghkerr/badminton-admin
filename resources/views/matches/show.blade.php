<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pertandingan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Match Info -->
            <div class="bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl overflow-hidden mb-6">
                <div class="p-5 sm:p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                {{ $match->session->session_date->format('d M Y') }} - Lapangan {{ $match->court_no }}
                            </h3>
                            <div class="text-sm text-gray-600">
                                <span class="mr-4">Lokasi: {{ $match->session->location }}</span>
                                <span>Mulai: {{ $match->started_at->format('H:i') }}</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            @if(!$match->ended_at)
                                <a href="{{ route('matches.edit', $match) }}" 
                                   class="inline-flex items-center justify-center px-4 py-2 bg-amber-500 text-white rounded-xl hover:bg-amber-600 text-sm font-medium">
                                    Input Skor
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Teams Display -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Team 1 -->
                        <div class="text-center">
                            <h4 class="text-lg font-semibold text-blue-600 mb-4">Team 1</h4>
                            <div class="space-y-2">
                                @foreach($team1Players as $player)
                                    <div class="p-3 bg-blue-50 rounded-lg">
                                        <div class="font-medium">{{ $player->player->name }}</div>
                                        <div class="text-sm text-gray-600">Grade {{ $player->player->grade }}</div>
                                    </div>
                                @endforeach
                            </div>
                            @if($match->team1_score !== null)
                                <div class="mt-4 text-3xl font-bold text-blue-600">
                                    {{ $match->team1_score }}
                                </div>
                            @endif
                        </div>

                        <!-- Team 2 -->
                        <div class="text-center">
                            <h4 class="text-lg font-semibold text-red-600 mb-4">Team 2</h4>
                            <div class="space-y-2">
                                @foreach($team2Players as $player)
                                    <div class="p-3 bg-red-50 rounded-lg">
                                        <div class="font-medium">{{ $player->player->name }}</div>
                                        <div class="text-sm text-gray-600">Grade {{ $player->player->grade }}</div>
                                    </div>
                                @endforeach
                            </div>
                            @if($match->team2_score !== null)
                                <div class="mt-4 text-3xl font-bold text-red-600">
                                    {{ $match->team2_score }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Result -->
                    @if($match->winner_team)
                        <div class="mt-8 p-4 bg-green-50 rounded-xl text-center">
                            <div class="text-lg font-semibold text-green-800">
                                🏆 Pemenang: Team {{ $match->winner_team }}
                            </div>
                            <div class="text-sm text-green-600 mt-1">
                                Skor: {{ $match->team1_score }} - {{ $match->team2_score }}
                            </div>
                        </div>
                    @endif

                    @if($match->notes)
                        <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                            <h5 class="font-medium text-gray-900 mb-2">Catatan</h5>
                            <p class="text-gray-700">{{ $match->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl overflow-hidden">
                <div class="p-5 sm:p-6">
                    <div class="flex justify-between">
                        <a href="{{ route('sessions.show', $match->session) }}" 
                           class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-900 text-white rounded-xl hover:bg-slate-800 text-sm font-medium">
                            Kembali ke Sesi
                        </a>
                        
                        @if(!$match->ended_at)
                            <form action="{{ route('matches.destroy', $match) }}" method="POST" 
                                  class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pertandingan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 text-sm font-medium">
                                    Batalkan Pertandingan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
