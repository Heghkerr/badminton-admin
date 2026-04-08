<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Pertandingan
            </h2>
            <div class="text-sm text-gray-500">
                Total: {{ $matches->count() }} pertandingan
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Actions Bar -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-5 sm:p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Pertandingan</h3>
                        <p class="text-sm text-gray-500 mt-1">Riwayat pertandingan komunitas PB Hura Hore</p>
                    </div>
                    <a href="{{ route('sessions.index') }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Pertandingan Baru
                    </a>
                </div>

                <!-- Search and Filter -->
                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Cari pertandingan..." 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <select class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="ongoing">Sedang Berlangsung</option>
                        <option value="completed">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                    <select class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Sesi</option>
                        @foreach(App\Models\Session::latest()->take(10)->get() as $session)
                            <option value="{{ $session->id }}">{{ $session->location }} - {{ $session->session_date->format('d M Y') }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Matches Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($matches as $match)
                    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-5 sm:p-6">
                        <!-- Match Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-full p-3 mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Pertandingan #{{ $match->id }}</h4>
                                    <p class="text-sm text-gray-500">{{ $match->session->location }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($match->winner_team)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                @elseif($match->started_at && !$match->ended_at)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Berlangsung
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Scheduled
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Match Details -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Tanggal</span>
                                <span class="text-sm font-medium text-gray-800">{{ $match->session->session_date->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Lapangan</span>
                                <span class="text-sm font-medium text-gray-800">Lapangan {{ $match->court_no }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Skor</span>
                                @if($match->team1_score !== null && $match->team2_score !== null)
                                    <span class="text-sm font-medium text-gray-800">
                                        {{ $match->team1_score }} - {{ $match->team2_score }}
                                        @if($match->winner_team)
                                            (Team {{ $match->winner_team }} Menang)
                                        @endif
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">Belum ada skor</span>
                                @endif
                            </div>
                        </div>

                        <!-- Players Preview -->
                        <div class="mb-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <p class="text-xs text-gray-500 mb-2">Team 1</p>
                                    <div class="space-y-1">
                                        @foreach($match->matchPlayers->where('team_no', 1)->take(2) as $player)
                                            <p class="text-xs text-gray-700">{{ $player->player->name }}</p>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="text-xs text-gray-500 mb-2">Team 2</p>
                                    <div class="space-y-1">
                                        @foreach($match->matchPlayers->where('team_no', 2)->take(2) as $player)
                                            <p class="text-xs text-gray-700">{{ $player->player->name }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-2 pt-4 border-t border-gray-100">
                            <a href="{{ route('matches.show', $match) }}" 
                               class="flex-1 flex items-center justify-center px-3 py-2.5 text-sm bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-colors font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </a>
                            @if(!$match->winner_team)
                                <a href="{{ route('matches.edit', $match) }}" 
                                   class="flex-1 flex items-center justify-center px-3 py-2.5 text-sm bg-orange-50 text-orange-600 rounded-xl hover:bg-orange-100 transition-colors font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Input Skor
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($matches->count() === 0)
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pertandingan</h3>
                    <p class="text-gray-500 mb-6">Mulai dengan membuat sesi bermain dan pertandingan pertama</p>
                    <a href="{{ route('sessions.create') }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Sesi Bermain
                    </a>
                </div>
            @endif

            <!-- Pagination -->
            @if($matches->hasPages())
                <div class="mt-6">
                    {{ $matches->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
