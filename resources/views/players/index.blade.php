<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Pemain
            </h2>
            <div class="text-sm text-gray-500">
                Total: {{ $players->count() }} pemain
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
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Pemain</h3>
                        <p class="text-sm text-gray-500 mt-1">Kelola data pemain komunitas PB Hura Hore</p>
                    </div>
                    <a href="{{ route('players.create') }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Pemain
                    </a>
                </div>
                <!-- Search and Filter -->
                <form method="GET" action="{{ route('players.index') }}" class="mt-6 flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Cari nama pemain..." 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <select name="grade" 
                            class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            onchange="this.form.submit()">
                        <option value="">Semua Grade</option>
                        <option value="A" {{ request('grade') == 'A' ? 'selected' : '' }}>Grade A</option>
                        <option value="B" {{ request('grade') == 'B' ? 'selected' : '' }}>Grade B</option>
                        <option value="C" {{ request('grade') == 'C' ? 'selected' : '' }}>Grade C</option>
                        <option value="D" {{ request('grade') == 'D' ? 'selected' : '' }}>Grade D</option>
                    </select>
                    <select name="is_active" 
                            class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </form>
            </div>

            <!-- Players Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($players as $index => $player)
                    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-5 sm:p-6 {{ $player->is_active ? '' : 'opacity-50' }}">
                        <!-- Player Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-full p-3 mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $player->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $player->phone ?: 'No telepon' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($player->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Player Details -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Grade</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $player->grade }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500">Membership</span>
                                @if($player->is_member)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Member
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Non-Member
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-2 pt-4 border-t border-gray-100">
                            <a href="{{ route('players.show', $player) }}" 
                               class="flex-1 flex items-center justify-center px-3 py-2.5 text-sm bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-colors font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat
                            </a>
                            <a href="{{ route('players.edit', $player) }}" 
                               class="flex-1 flex items-center justify-center px-3 py-2.5 text-sm bg-gray-50 text-gray-600 rounded-xl hover:bg-gray-100 transition-colors font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($players->count() === 0)
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pemain</h3>
                    <p class="text-gray-500 mb-6">Mulai dengan menambahkan pemain pertama</p>
                    <a href="{{ route('players.create') }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Pemain Pertama
                    </a>
                </div>
            @endif

            <!-- Pagination -->
            @if($players->hasPages())
                <div class="mt-6">
                    {{ $players->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>