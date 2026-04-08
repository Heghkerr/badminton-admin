<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Sesi Bermain
            </h2>
            <div class="flex items-center space-x-3">
                <a href="{{ route('sessions.index') }}" 
                   class="text-gray-500 hover:text-gray-700 flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('sessions.edit', $session) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-xl hover:bg-blue-700 transition-colors font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
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

            <!-- Session Info Card -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-5 sm:p-6 mb-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-full p-3 mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $session->session_date->format('d M Y') }} - {{ $session->location }}</h3>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-2 text-sm text-gray-600">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    {{ $session->courts_count }} Lapangan
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Target: {{ $session->scoring_target ?? 42 }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Biaya: {{ number_format($session->per_visit_fee ?? 0, 0, ',', '.') }}
                                </span>
                                
                            </div>
                            @if($session->notes)
                                <p class="mt-2 text-sm text-gray-500">{{ $session->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Check-in Players Section (Full Width) -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden mb-6">
                <div class="p-5 sm:p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Pemain yang Check-in</h3>
                        <span class="text-sm text-gray-500">{{ $session->attendances->count() }} pemain</span>
                    </div>
                </div>
                
                <div class="p-5 sm:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2 max-h-64 overflow-y-auto">
                        @if($session->attendances->count() > 0)
                            @foreach($session->attendances as $attendance)
                                <div class="flex items-center p-2 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                    <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-2">
                                        <span class="text-white text-xs font-medium">{{ substr($attendance->player->name, 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-xs font-medium text-gray-800 truncate block">{{ $attendance->player->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $attendance->player->grade }}</span>
                                        <div class="mt-1 flex items-center justify-between">
                                            @if($attendance->player->is_member)
                                                <span class="px-1 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800">Member</span>
                                            @else
                                                <span class="px-1 py-0.5 text-xs rounded-full bg-orange-100 text-orange-800">Non-Member</span>
                                            @endif
                                            @if(isset($ongoingPlayerIds) && in_array($attendance->player_id, $ongoingPlayerIds, true))
                                                <span class="ml-1 px-1 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-800">Main</span>
                                            @endif
                                            @php
                                                $sessionMatchesCount = $attendance->played_count ?? 0;
                                            @endphp
                                            <span class="text-xs text-gray-600 font-medium">{{ $sessionMatchesCount }}x</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('sessions.checkout', [$session, $attendance]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin check-out pemain ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-1 p-1 text-red-500 hover:text-red-700 hover:bg-red-50 rounded transition-colors" title="Check-out">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-500 col-span-full text-center py-4">Belum ada pemain check-in</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Generate Matches -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Rekomendasi Pasangan</h3>
                        <span class="text-sm text-gray-500">{{ $session->matches->count() }} pertandingan</span>
                    </div>
                </div>
                
                <div class="p-5 sm:p-6">
                    <div class="mb-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                            <h4 class="text-sm font-medium text-blue-800 mb-2">Sistem Pasangan Seimbang</h4>
                            <p class="text-sm text-blue-600">Sistem akan membuat rekomendasi pasangan yang seimbang berdasarkan grade:</p>
                            <ul class="text-sm text-blue-600 mt-2 space-y-1">
                                <li>• Grade A akan dipasangkan dengan Grade D</li>
                                <li>• Grade B akan dipasangkan dengan Grade C</li>
                                <li>• Jika ada 4 pemain (2A, 2D): A dengan D</li>
                                <li>• Jika ada 4 pemain (A,B,C,D): A dengan D, B dengan C</li>
                            </ul>
                        </div>
                        
                        @if($session->attendances->count() >= 4)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <form action="{{ route('sessions.generate-pairs', $session) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full px-4 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors flex items-center justify-center text-sm font-medium">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @if(session()->has('pairs') && count(session('pairs')) > 0)
                                            Rekomendasi Lain
                                        @else
                                            Buat Rekomendasi Pasangan
                                        @endif
                                    </button>
                                </form>
                                
                                <button onclick="toggleManualMatch()" 
                                        class="w-full px-4 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors flex items-center justify-center text-sm font-medium">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Buat Pertandingan Manual
                                </button>
                            </div>
                            
                            <!-- Manual Match Form (Hidden by default) -->
                            <div id="manualMatchForm" class="hidden mt-4">
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="text-md font-semibold text-gray-800 mb-4">Buat Pertandingan Manual</h4>
                                    <form action="{{ route('sessions.create-match', $session) }}" method="POST">
                                        @csrf
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Team 1 -->
                                            <div>
                                                <h5 class="text-sm font-medium text-blue-600 mb-3">Team 1</h5>
                                                <div class="space-y-2">
                                                    <div class="relative">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                            </svg>
                                                        </div>
                                                        <input type="text" 
                                                               id="team1_player1_input"
                                                               placeholder="Cari pemain 1..." 
                                                               class="pl-10 w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                               onkeyup="showPlayerDropdown('team1_player1_input', 'team1_player1')"
                                                               onfocus="showPlayerDropdown('team1_player1_input', 'team1_player1')"
                                                               onblur="hidePlayerDropdown('team1_player1')"
                                                               autocomplete="off">
                                                        <div id="team1_player1_dropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                                        </div>
                                                        <input type="hidden" name="team1_player1" id="team1_player1" required>
                                                    </div>
                                                    <div class="relative">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                            </svg>
                                                        </div>
                                                        <input type="text" 
                                                               id="team1_player2_input"
                                                               placeholder="Cari pemain 2..." 
                                                               class="pl-10 w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                               onkeyup="showPlayerDropdown('team1_player2_input', 'team1_player2')"
                                                               onfocus="showPlayerDropdown('team1_player2_input', 'team1_player2')"
                                                               onblur="hidePlayerDropdown('team1_player2')"
                                                               autocomplete="off">
                                                        <div id="team1_player2_dropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                                        </div>
                                                        <input type="hidden" name="team1_player2" id="team1_player2" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Team 2 -->
                                            <div>
                                                <h5 class="text-sm font-medium text-green-600 mb-3">Team 2</h5>
                                                <div class="space-y-2">
                                                    <div class="relative">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                            </svg>
                                                        </div>
                                                        <input type="text" 
                                                               id="team2_player1_input"
                                                               placeholder="Cari pemain 1..." 
                                                               class="pl-10 w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                               onkeyup="showPlayerDropdown('team2_player1_input', 'team2_player1')"
                                                               onfocus="showPlayerDropdown('team2_player1_input', 'team2_player1')"
                                                               onblur="hidePlayerDropdown('team2_player1')"
                                                               autocomplete="off">
                                                        <div id="team2_player1_dropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                                        </div>
                                                        <input type="hidden" name="team2_player1" id="team2_player1" required>
                                                    </div>
                                                    <div class="relative">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                            </svg>
                                                        </div>
                                                        <input type="text" 
                                                               id="team2_player2_input"
                                                               placeholder="Cari pemain 2..." 
                                                               class="pl-10 w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                               onkeyup="showPlayerDropdown('team2_player2_input', 'team2_player2')"
                                                               onfocus="showPlayerDropdown('team2_player2_input', 'team2_player2')"
                                                               onblur="hidePlayerDropdown('team2_player2')"
                                                               autocomplete="off">
                                                        <div id="team2_player2_dropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                                        </div>
                                                        <input type="hidden" name="team2_player2" id="team2_player2" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Lapangan</label>
                                            @php
                                                $occupiedCourtsForManual = $session->matches->where('status', 'ongoing')->pluck('court_no')->unique()->values()->all();
                                            @endphp
                                            <select name="court_no" required class="w-full px-2 py-1 text-sm border border-gray-300 rounded">
                                                @for($i = 1; $i <= $session->courts_count; $i++)
                                                    @if(in_array($i, $occupiedCourtsForManual, true))
                                                        <option value="{{ $i }}" disabled>L{{ $i }} (dipakai)</option>
                                                    @else
                                                        <option value="{{ $i }}">L{{ $i }}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        
                                        <div class="mt-4 flex justify-end space-x-2">
                                            <button type="button" onclick="toggleManualMatch()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                                Batal
                                            </button>
                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                                Buat Pertandingan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-xl">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-gray-500">Minimal 4 pemain diperlukan untuk membuat pertandingan</p>
                                <p class="text-sm text-gray-400 mt-1">Saat ini: {{ $session->attendances->count() }} pemain</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Display Pairs if available -->
                    @if(session('pairs'))
                        <div class="border-t border-gray-100 pt-4">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-sm font-medium text-gray-700">Rekomendasi Pasangan ({{ count(session('pairs')) }} pasangan)</h4>
                                <div class="flex space-x-2">
                                    <button type="submit"
                                            form="selectedMatchesForm"
                                            id="createSelectedBtn"
                                            class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors flex items-center font-medium disabled:bg-gray-400 disabled:cursor-not-allowed"
                                            disabled>
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span id="createSelectedLabel">Buat Yang Dipilih (0)</span>
                                    </button>
                                    <form action="{{ route('sessions.create-multiple-matches', $session) }}" method="POST" onsubmit="return confirm('Buat {{ count(session('pairs')) }} pertandingan sekaligus?')">
                                        @csrf
                                        <button type="submit"
                                                class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors flex items-center font-medium">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Buat Semua
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @php
                                $occupiedCourts = $session->matches->where('status', 'ongoing')->pluck('court_no')->unique()->values()->all();
                            @endphp
                            <form action="{{ route('sessions.create-selected-matches', $session) }}" method="POST" id="selectedMatchesForm" onsubmit="return confirm('Buat pertandingan yang dipilih?')">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach(session('pairs') as $index => $pair)
                                        @php
                                            $playedCounts = [];
                                            foreach($pair as $playerAttendance) {
                                                $playedCounts[] = $playerAttendance->played_count ?? 0;
                                            }
                                        @endphp
                                        <div class="border border-green-200 rounded-lg p-4 bg-green-50">
                                            <div class="flex items-start space-x-3">
                                                <input type="checkbox"
                                                       name="selected_pairs[]"
                                                       value="{{ $index }}"
                                                       class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                       onchange="updateSelectedCount()">
                                                <div class="flex-1">
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="text-sm text-gray-800 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                        <div class="flex-1">
                                                            <div class="font-medium">{{ $pair[0]->player->name }}</div>
                                                            <div class="text-xs text-gray-500">Grade {{ $pair[0]->player->grade }} • sudah main {{ $playedCounts[0] }}x</div>
                                                        </div>
                                                    </div>
                                                    <div class="text-sm text-gray-800 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                        <div class="flex-1">
                                                            <div class="font-medium">{{ $pair[2]->player->name }}</div>
                                                            <div class="text-xs text-gray-500">Grade {{ $pair[2]->player->grade }} • sudah main {{ $playedCounts[2] }}x</div>
                                                        </div>
                                                    </div>
                                                    <div class="text-sm text-gray-800 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                        <div class="flex-1">
                                                            <div class="font-medium">{{ $pair[1]->player->name }}</div>
                                                            <div class="text-xs text-gray-500">Grade {{ $pair[1]->player->grade }} • sudah main {{ $playedCounts[1] }}x</div>
                                                        </div>
                                                    </div>
                                                    <div class="text-sm text-gray-800 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                        <div class="flex-1">
                                                            <div class="font-medium">{{ $pair[3]->player->name }}</div>
                                                            <div class="text-xs text-gray-500">Grade {{ $pair[3]->player->grade }} • sudah main {{ $playedCounts[3] }}x</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-3 pt-3 border-t border-green-100 flex justify-between items-center">
                                                    <span class="text-xs text-green-600">Pasangan #{{ $index + 1 }} - Seimbang berdasarkan grade</span>
                                                    <div class="flex items-center space-x-2">
                                                        <button type="button"
                                                                class="px-3 py-1.5 bg-white text-gray-700 text-xs rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors font-medium"
                                                                onclick="editPairFromRecommendation({{ $index }})"
                                                                data-pair-index="{{ $index }}"
                                                                data-t1p1-id="{{ $pair[0]->player_id }}"
                                                                data-t1p1-name="{{ $pair[0]->player->name }}"
                                                                data-t1p2-id="{{ $pair[1]->player_id }}"
                                                                data-t1p2-name="{{ $pair[1]->player->name }}"
                                                                data-t2p1-id="{{ $pair[2]->player_id }}"
                                                                data-t2p1-name="{{ $pair[2]->player->name }}"
                                                                data-t2p2-id="{{ $pair[3]->player_id }}"
                                                                data-t2p2-name="{{ $pair[3]->player->name }}">
                                                            Edit
                                                        </button>
                                                        <form action="{{ route('sessions.create-match', $session) }}" method="POST" class="flex items-center space-x-2">
                                                            @csrf
                                                            <input type="hidden" name="team1_player1" value="{{ $pair[0]->player_id }}">
                                                            <input type="hidden" name="team1_player2" value="{{ $pair[1]->player_id }}">
                                                            <input type="hidden" name="team2_player1" value="{{ $pair[2]->player_id }}">
                                                            <input type="hidden" name="team2_player2" value="{{ $pair[3]->player_id }}">
                                                            <select name="court_no" required class="px-2 py-1 text-xs border border-gray-200 rounded">
                                                                @for($i = 1; $i <= $session->courts_count; $i++)
                                                                    @if(!in_array($i, $occupiedCourts, true))
                                                                        <option value="{{ $i }}">L{{ $i }}</option>
                                                                    @endif
                                                                @endfor
                                                            </select>
                                                            <button type="submit"
                                                                    class="px-3 py-1.5 bg-green-600 text-white text-xs rounded-xl hover:bg-green-700 transition-colors flex items-center font-medium">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                                </svg>
                                                                Buat
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    @endif
                    
                    <!-- Existing Matches -->
                    @if($session->matches->count() > 0)
                        <div class="border-t border-gray-100 pt-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Pertandingan yang Sedang Berlangsung</h4>
                            <div class="space-y-4">
                                @foreach($session->matches as $match)
                                    <div class="border border-gray-200 rounded-lg p-4 bg-white shadow-sm">
                                        <!-- Match Header -->
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-3">
                                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                    Lapangan {{ $match->court_no }}
                                                </span>
                                                <span class="text-xs text-gray-500">{{ $match->created_at->format('H:i') }}</span>
                                                @if($match->status === 'completed')
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                                        Berlangsung
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Teams and Score -->
                                        <div class="grid grid-cols-3 gap-4 mb-4">
                                            <!-- Team 1 -->
                                            <div class="text-center">
                                                <div class="text-sm font-medium text-blue-600 mb-2">Team 1</div>
                                                @foreach($match->matchPlayers->where('team_no', 1) as $player)
                                                    <div class="text-sm text-gray-700 mb-1 font-medium">{{ $player->player->name }}</div>
                                                @endforeach
                                                <div class="mt-2">
                                                    <span class="text-2xl font-bold text-gray-800">{{ $match->team1_score ?? 0 }}</span>
                                                </div>
                                            </div>

                                            <!-- VS -->
                                            <div class="flex items-center justify-center">
                                                <div class="text-center">
                                                    <div class="text-xs text-gray-500 mb-2">VS</div>
                                                    @if($match->status === 'completed')
                                                        <div class="text-xs text-green-600 font-medium">
                                                            @if($match->team1_score > $match->team2_score)
                                                                Team 1 Menang
                                                            @elseif($match->team2_score > $match->team1_score)
                                                                Team 2 Menang
                                                            @else
                                                                Draw
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Team 2 -->
                                            <div class="text-center">
                                                <div class="text-sm font-medium text-green-600 mb-2">Team 2</div>
                                                @foreach($match->matchPlayers->where('team_no', 2) as $player)
                                                    <div class="text-sm text-gray-700 mb-1 font-medium">{{ $player->player->name }}</div>
                                                @endforeach
                                                <div class="mt-2">
                                                    <span class="text-2xl font-bold text-gray-800">{{ $match->team2_score ?? 0 }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Match Actions -->
                                        <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                                            <div class="flex space-x-2">
                                                @if($match->status !== 'completed')
                                                    <form action="{{ route('matches.update-score', $match) }}" method="POST" class="flex items-center space-x-1" onsubmit="return this.submit()">
                                                        @csrf
                                                        <input type="number" name="team1_score" value="{{ $match->team1_score ?? 0 }}" min="0" max="42" class="w-12 px-1 py-0.5 text-xs border border-gray-200 rounded text-center">
                                                        <span class="text-xs text-gray-500">-</span>
                                                        <input type="number" name="team2_score" value="{{ $match->team2_score ?? 0 }}" min="0" max="42" class="w-12 px-1 py-0.5 text-xs border border-gray-200 rounded text-center">
                                                        <button type="submit" class="px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                                                            Update & Selesai
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('matches.complete', $match) }}" method="POST" onsubmit="return confirm('Selesaikan pertandingan tanpa input skor?')">
                                                        @csrf
                                                        <button type="submit" class="px-2 py-1 bg-gray-600 text-white text-xs rounded hover:bg-gray-700">
                                                            Selesai
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('matches.show', $match) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    Detail
                                                </a>
                                                <form action="{{ route('matches.destroy', $match) }}" method="POST" onsubmit="return confirm('Hapus pertandingan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function toggleManualMatch() {
    const form = document.getElementById('manualMatchForm');
    form.classList.toggle('hidden');
}

function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('input[name="selected_pairs[]"]:checked');
    const count = checkboxes.length;
    const button = document.getElementById('createSelectedBtn');
    const label = document.getElementById('createSelectedLabel');
    
    if (label) {
        label.textContent = `Buat Yang Dipilih (${count})`;
    }
    
    // Enable/disable button
    if (count > 0) {
        button.disabled = false;
    } else {
        button.disabled = true;
    }
}

function editPairFromRecommendation(index) {
    const btn = document.querySelector(`button[data-pair-index="${index}"]`);
    if (!btn) return;

    // Ensure manual form is visible
    const form = document.getElementById('manualMatchForm');
    if (form && form.classList.contains('hidden')) {
        form.classList.remove('hidden');
    }

    const setPlayer = (prefix, id, name) => {
        const input = document.getElementById(`${prefix}_input`);
        const hidden = document.getElementById(prefix);
        if (input) input.value = name || '';
        if (hidden) hidden.value = id || '';
    };

    setPlayer('team1_player1', btn.dataset.t1p1Id, btn.dataset.t1p1Name);
    setPlayer('team1_player2', btn.dataset.t1p2Id, btn.dataset.t1p2Name);
    setPlayer('team2_player1', btn.dataset.t2p1Id, btn.dataset.t2p1Name);
    setPlayer('team2_player2', btn.dataset.t2p2Id, btn.dataset.t2p2Name);

    // Scroll into view for easier editing
    if (form) {
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// Player data for dropdowns
const playerData = [
    @foreach($session->attendances as $attendance)
        {
            id: {{ $attendance->player_id }},
            name: "{{ $attendance->player->name }}",
            grade: "{{ $attendance->player->grade }}"
        },
    @endforeach
];

// Show player dropdown (TomSelect-like)
function showPlayerDropdown(inputId, hiddenId) {
    const input = document.getElementById(inputId);
    const dropdown = document.getElementById(hiddenId + '_dropdown');
    const hiddenInput = document.getElementById(hiddenId);
    const searchTerm = input.value.toLowerCase();
    
    // Clear dropdown
    dropdown.innerHTML = '';
    
    // Filter players
    const filteredPlayers = playerData.filter(player => 
        player.name.toLowerCase().includes(searchTerm)
    );
    
    // Create dropdown items
    if (filteredPlayers.length > 0) {
        filteredPlayers.forEach(player => {
            const item = document.createElement('div');
            item.className = 'px-3 py-2 hover:bg-blue-50 cursor-pointer text-sm border-b border-gray-100 last:border-b-0';
            item.innerHTML = `
                <div class="flex items-center justify-between">
                    <span class="font-medium text-gray-800">${player.name}</span>
                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">${player.grade}</span>
                </div>
            `;
            
            // Handle click
            item.addEventListener('mousedown', function(e) {
                e.preventDefault();
                input.value = player.name;
                hiddenInput.value = player.id;
                hidePlayerDropdown(hiddenId);
            });
            
            // Handle hover
            item.addEventListener('mouseenter', function() {
                this.classList.add('bg-blue-50');
            });
            
            item.addEventListener('mouseleave', function() {
                this.classList.remove('bg-blue-50');
            });
            
            dropdown.appendChild(item);
        });
        
        // Show dropdown
        dropdown.classList.remove('hidden');
    } else {
        // No results
        const noResults = document.createElement('div');
        noResults.className = 'px-3 py-4 text-center text-sm text-gray-500';
        noResults.textContent = 'Tidak ada pemain yang ditemukan';
        dropdown.appendChild(noResults);
        dropdown.classList.remove('hidden');
    }
}

// Hide player dropdown
function hidePlayerDropdown(hiddenId) {
    setTimeout(() => {
        const dropdown = document.getElementById(hiddenId + '_dropdown');
        if (dropdown) {
            dropdown.classList.add('hidden');
        }
    }, 200); // Delay to allow click on dropdown items
}

// Handle keyboard navigation
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('[id$="_input"]');
    
    inputs.forEach(input => {
        let currentFocus = -1;
        
        input.addEventListener('keydown', function(e) {
            const dropdown = document.getElementById(input.id.replace('_input', '_dropdown'));
            const items = dropdown.querySelectorAll('div');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                currentFocus++;
                addActive(items, currentFocus);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                currentFocus--;
                addActive(items, currentFocus);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (currentFocus > -1 && items[currentFocus]) {
                    items[currentFocus].click();
                }
            } else if (e.key === 'Escape') {
                hidePlayerDropdown(input.id.replace('_input', ''));
            }
        });
        
        input.addEventListener('focus', function() {
            // Pre-fill if there's a selected value
            const hiddenId = this.id.replace('_input', '');
            const hiddenInput = document.getElementById(hiddenId);
            if (hiddenInput.value) {
                const player = playerData.find(p => p.id == hiddenInput.value);
                if (player) {
                    this.value = player.name;
                }
            }
        });
    });
});

function addActive(items, index) {
    if (!items) return;
    
    // Remove active class from all items
    removeActive(items);
    
    if (index >= items.length) index = 0;
    if (index < 0) index = items.length - 1;
    
    // Add active class to current item
    items[index].classList.add('bg-blue-50');
    currentFocus = index;
}

function removeActive(items) {
    items.forEach(item => item.classList.remove('bg-blue-50'));
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('[id$="_input"]') && !e.target.closest('[id$="_dropdown"]')) {
        const dropdowns = document.querySelectorAll('[id$="_dropdown"]');
        dropdowns.forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});
</script>
