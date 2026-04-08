<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Sesi Bermain Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('sessions.store') }}" method="POST">
                        @csrf

                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="session_date" class="block text-sm font-medium text-gray-700">
                                    Tanggal Sesi <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       id="session_date" 
                                       name="session_date" 
                                       value="{{ old('session_date', now()->format('Y-m-d')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                       required>
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">
                                    Lokasi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                       placeholder="Gor Badminton ABC"
                                       required>
                            </div>

                            <div>
                                <label for="courts_count" class="block text-sm font-medium text-gray-700">
                                    Jumlah Lapangan <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       id="courts_count" 
                                       name="courts_count" 
                                       value="{{ old('courts_count', 1) }}"
                                       min="1"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                       required>
                            </div>

                            <div>
                                <label for="scoring_target" class="block text-sm font-medium text-gray-700">
                                    Target Skor
                                </label>
                                <input type="number" 
                                       id="scoring_target" 
                                       name="scoring_target" 
                                       value="{{ old('scoring_target', 21) }}"
                                       min="1"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                       placeholder="21">
                            </div>

                            <div>
                                <label for="per_visit_fee" class="block text-sm font-medium text-gray-700">
                                    Biaya Per Kunjungan (Non-Member) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2.5 text-gray-500 text-sm">Rp</span>
                                    <input type="number" 
                                           id="per_visit_fee" 
                                           name="per_visit_fee" 
                                           value="{{ old('per_visit_fee', 25000) }}"
                                           min="0"
                                           step="1000"
                                           class="mt-1 block w-full pl-8 pr-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                           placeholder="25000"
                                           required>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Biaya untuk pemain non-member per kunjungan</p>
                            </div>

                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700">
                                    Catatan
                                </label>
                                <textarea id="notes" 
                                          name="notes" 
                                          rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                          placeholder="Catatan tambahan untuk sesi ini...">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <!-- Check-in Players Section -->
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Check-in Pemain</h3>
                            
                            @php
                                $allPlayers = \App\Models\Player::where('is_active', true)->orderBy('name', 'asc')->get();
                            @endphp

                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700">Pilih Pemain (Bisa centang banyak)</label>
                                    <span class="text-xs text-gray-500">{{ $allPlayers->count() }} pemain</span>
                                </div>

                                <div class="mb-3">
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                        <input type="text"
                                               id="playerSearch"
                                               placeholder="Cari pemain..."
                                               class="pl-10 w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               onkeyup="filterPlayers()">
                                    </div>
                                </div>

                                @if($allPlayers->count() > 0)
                                    <div id="playersList" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2 max-h-64 overflow-y-auto border border-gray-200 rounded-xl p-3">
                                        @foreach($allPlayers as $player)
                                            <div class="player-item" data-player-name="{{ strtolower($player->name) }}">
                                                <label class="flex items-center p-2 bg-gray-50 rounded-xl hover:bg-gray-100 cursor-pointer transition-colors">
                                                    <input type="checkbox"
                                                           name="player_ids[]"
                                                           value="{{ $player->id }}"
                                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2">
                                                    <div class="flex-1 min-w-0">
                                                        <span class="text-xs font-medium text-gray-800 truncate block">{{ $player->name }}</span>
                                                        <span class="text-xs text-gray-500">{{ $player->grade }}</span>
                                                        <div class="mt-1">
                                                            @if($player->is_member)
                                                                <span class="px-1 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800">Member</span>
                                                            @else
                                                                <span class="px-1 py-0.5 text-xs rounded-full bg-orange-100 text-orange-800">Non-Member</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 text-center py-4 border border-gray-200 rounded-xl">Tidak ada pemain aktif</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('sessions.index') }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Buat Sesi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function filterPlayers() {
    const searchInput = document.getElementById('playerSearch');
    const searchTerm = (searchInput?.value || '').toLowerCase();
    const items = document.querySelectorAll('.player-item');

    items.forEach(item => {
        const name = item.dataset.playerName || '';
        item.style.display = name.includes(searchTerm) ? 'block' : 'none';
    });
}
</script>
