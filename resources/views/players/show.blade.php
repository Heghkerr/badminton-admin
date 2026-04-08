<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Pemain
            </h2>
            <a href="{{ route('players.index') }}" 
               class="text-gray-500 hover:text-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Player Info Card -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-5 sm:p-6 mb-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-full p-4 mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $player->name }}</h3>
                            <p class="text-gray-500">{{ $player->phone ?: 'No telepon' }}</p>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Grade {{ $player->grade }}
                                </span>
                                @if($player->is_member)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Member
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Non-Member
                                    </span>
                                @endif
                                @if($player->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('players.edit', $player) }}" 
                           class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Total Sesi</p>
                            <p class="text-3xl font-bold mt-2">{{ $player->sessionAttendances->count() }}</p>
                        </div>
                        <div class="bg-green-400 bg-opacity-50 rounded-full p-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Total Pertandingan</p>
                            <p class="text-3xl font-bold mt-2">{{ $player->matchPlayers->count() }}</p>
                        </div>
                        <div class="bg-purple-400 bg-opacity-50 rounded-full p-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Total Pembayaran</p>
                            <p class="text-3xl font-bold mt-2">Rp {{ number_format($player->financialTransactions->where('type', 'income')->sum('amount'), 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-orange-400 bg-opacity-50 rounded-full p-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Win Rate</p>
                            <p class="text-3xl font-bold mt-2">
                                @php
                                    $totalMatches = $player->matchPlayers->count();
                                    $wonMatches = 0;
                                    foreach($player->matchPlayers as $matchPlayer) {
                                        $match = $matchPlayer->match;
                                        if($match->winner_team == $matchPlayer->team_no) {
                                            $wonMatches++;
                                        }
                                    }
                                    $winRate = $totalMatches > 0 ? round(($wonMatches / $totalMatches) * 100, 1) : 0;
                                @endphp
                                {{ $winRate }}%
                            </p>
                        </div>
                        <div class="bg-blue-400 bg-opacity-50 rounded-full p-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
                <div class="border-b border-gray-100">
                    <nav class="flex -mb-px">
                        <button onclick="showTab('sessions')" id="sessions-tab" 
                                class="py-4 px-6 text-sm font-medium text-blue-600 border-b-2 border-blue-500 focus:outline-none">
                            Riwayat Sesi
                        </button>
                        <button onclick="showTab('matches')" id="matches-tab" 
                                class="py-4 px-6 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent focus:outline-none">
                            Riwayat Pertandingan
                        </button>
                        <button onclick="showTab('payments')" id="payments-tab" 
                                class="py-4 px-6 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent focus:outline-none">
                            Riwayat Pembayaran
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-5 sm:p-6">
                    <!-- Sessions Tab -->
                    <div id="sessions-content" class="tab-content">
                        <div class="space-y-4">
                            @php
                                $attendances = $player->sessionAttendances()->with('session')->orderBy('checked_in_at', 'desc')->get();
                            @endphp
                            @if($attendances->count() > 0)
                                @foreach($attendances as $attendance)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center">
                                            <div class="bg-green-100 rounded-full p-2 mr-3">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $attendance->session->location }}</p>
                                                <p class="text-sm text-gray-500">{{ $attendance->session->session_date->format('d M Y') }} • {{ $attendance->checked_in_at->format('H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500">Main: {{ $attendance->played_count }}x</p>
                                            @if($attendance->per_visit_payment_status === 'paid')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Sudah Bayar
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Belum Bayar
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm">Belum ada riwayat sesi</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Matches Tab -->
                    <div id="matches-content" class="tab-content hidden">
                        <div class="space-y-4">
                            @php
                                $matchPlayers = $player->matchPlayers()->with('match.session')->orderBy('created_at', 'desc')->get();
                            @endphp
                            @if($matchPlayers->count() > 0)
                                @foreach($matchPlayers as $matchPlayer)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center">
                                            <div class="bg-purple-100 rounded-full p-2 mr-3">
                                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800">Team {{ $matchPlayer->team_no }} vs Team {{ $matchPlayer->team_no == 1 ? 2 : 1 }}</p>
                                                <p class="text-sm text-gray-500">{{ $matchPlayer->match->session->location }} • {{ $matchPlayer->match->session->session_date->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500">Lapangan {{ $matchPlayer->match->court_no }}</p>
                                            @if($matchPlayer->match->winner_team)
                                                @if($matchPlayer->match->winner_team == $matchPlayer->team_no)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Menang
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Kalah
                                                    </span>
                                                @endif
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Berlangsung
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm">Belum ada riwayat pertandingan</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payments Tab -->
                    <div id="payments-content" class="tab-content hidden">
                        <div class="space-y-4">
                            @php
                                $transactions = $player->financialTransactions()->orderBy('txn_date', 'desc')->get();
                            @endphp
                            @if($transactions->count() > 0)
                                @foreach($transactions as $transaction)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center">
                                            <div class="bg-orange-100 rounded-full p-2 mr-3">
                                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $transaction->category }}</p>
                                                <p class="text-sm text-gray-500">{{ $transaction->txn_date->format('d M Y') }} • {{ $transaction->method }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            @if($transaction->type === 'income')
                                                <p class="text-sm font-medium text-green-600">+Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                                            @else
                                                <p class="text-sm font-medium text-red-600">-Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm">Belum ada riwayat pembayaran</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all tabs
            document.querySelectorAll('[id$="-tab"]').forEach(tab => {
                tab.classList.remove('text-blue-600', 'border-blue-500');
                tab.classList.add('text-gray-500', 'border-transparent');
            });
            
            // Show selected content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Add active state to selected tab
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.remove('text-gray-500', 'border-transparent');
            activeTab.classList.add('text-blue-600', 'border-blue-500');
        }
    </script>
</x-app-layout>
