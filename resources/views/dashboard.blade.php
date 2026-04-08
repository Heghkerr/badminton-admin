@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600">Selamat datang di PB Hura Hore Admin System</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <!-- Total Players -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pemain</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalPlayers ?? 0 }}</p>
                        <div class="flex items-center mt-1 text-xs text-gray-500">
                            <span class="text-green-600">{{ $totalMembers ?? 0 }} Member</span>
                            <span class="mx-1">•</span>
                            <span class="text-orange-600">{{ $totalNonMembers ?? 0 }} Non-Member</span>
                        </div>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Sessions -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Sesi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalSessions ?? 0 }}</p>
                        @if(isset($activeSession) && $activeSession)
                            <div class="flex items-center mt-1 text-xs text-green-600">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="6"/>
                                </svg>
                                Sedang Aktif
                            </div>
                        @else
                            <div class="flex items-center mt-1 text-xs text-gray-500">
                                Tidak ada sesi hari ini
                            </div>
                        @endif
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Matches -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pertandingan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalMatches ?? 0 }}</p>
                        <div class="flex items-center mt-1 text-xs text-gray-500">
                            <span class="text-purple-600">{{ $todayMatches ?? 0 }} Hari ini</span>
                        </div>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Net Income -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pendapatan Bersih</p>
                        <p class="text-2xl font-bold {{ ($netIncome ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            Rp {{ number_format($netIncome ?? 0, 0, ',', '.') }}
                        </p>
                        <div class="flex items-center mt-1 text-xs text-gray-500">
                            <span class="text-green-600">+Rp {{ number_format($todayIncome ?? 0, 0, ',', '.') }} Hari ini</span>
                        </div>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Quick Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-5 sm:p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
                    <div class="space-y-3">
                        @if(isset($activeSession) && $activeSession)
                            <a href="{{ route('sessions.show', $activeSession) }}" 
                               class="block w-full text-center px-4 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors text-sm font-medium">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Kelola Sesi Aktif
                            </a>
                        @else
                            <a href="{{ route('sessions.create') }}" 
                               class="block w-full text-center px-4 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Buat Sesi Baru
                            </a>
                        @endif
                        
                        <a href="{{ route('players.create') }}" 
                           class="block w-full text-center px-4 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors text-sm font-medium">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Tambah Pemain
                        </a>
                        
                        <a href="{{ route('financial.index') }}" 
                           class="block w-full text-center px-4 py-3 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition-colors text-sm font-medium">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Lihat Keuangan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-5 sm:p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terkini</h2>
                    
                    <!-- Recent Sessions -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Sesi Terakhir</h3>
                        <div class="space-y-2">
                            @forelse(($recentSessions ?? collect()) as $session)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="bg-green-100 rounded-full p-2 mr-3">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $session->location }}</p>
                                            <p class="text-xs text-gray-500">{{ $session->session_date->format('d M Y') }} • {{ $session->attendances->count() }} pemain</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('sessions.show', $session) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                        Lihat
                                    </a>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-4">Belum ada sesi</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Matches -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Pertandingan Terakhir</h3>
                        <div class="space-y-2">
                            @forelse(($recentMatches ?? collect()) as $match)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="bg-purple-100 rounded-full p-2 mr-3">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Lapangan {{ $match->court_no }}</p>
                                            <p class="text-xs text-gray-500">{{ $match->created_at->format('d M Y H:i') }} • {{ $match->matchPlayers->count() }} pemain</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('matches.show', $match) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                        Lihat
                                    </a>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-4">Belum ada pertandingan</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
