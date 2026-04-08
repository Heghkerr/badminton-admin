<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Sesi Bermain
            </h2>
            <a href="{{ route('sessions.index') }}" 
               class="text-gray-500 hover:text-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <form method="POST" action="{{ route('sessions.update', $session) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Informasi Sesi</h3>
                        <p class="text-sm text-gray-500">Edit detail sesi bermain komunitas PB Hura Hore</p>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Session Date -->
                        <div>
                            <label for="session_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Sesi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="date" 
                                       id="session_date"
                                       name="session_date" 
                                       value="{{ $session->session_date->format('Y-m-d') }}"
                                       class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>
                            @error('session_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                Lokasi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="location"
                                       name="location" 
                                       value="{{ old('location', $session->location) }}"
                                       placeholder="Contoh: Lapangan PB Hura Hore"
                                       class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>
                            @error('location')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Courts Count -->
                        <div>
                            <label for="courts_count" class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Lapangan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <input type="number" 
                                       id="courts_count"
                                       name="courts_count" 
                                       value="{{ old('courts_count', $session->courts_count) }}"
                                       min="1"
                                       placeholder="Contoh: 2"
                                       class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>
                            @error('courts_count')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Scoring Target -->
                        <div>
                            <label for="scoring_target" class="block text-sm font-medium text-gray-700 mb-2">
                                Target Skor
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <input type="number" 
                                       id="scoring_target"
                                       name="scoring_target" 
                                       value="{{ old('scoring_target', $session->scoring_target) }}"
                                       min="1"
                                       placeholder="Contoh: 21"
                                       class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('scoring_target')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Per Visit Fee -->
                        <div>
                            <label for="per_visit_fee" class="block text-sm font-medium text-gray-700 mb-2">
                                Biaya Per Kunjungan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10V6m0 12v-2"></path>
                                    </svg>
                                </div>
                                <input type="number" 
                                       id="per_visit_fee"
                                       name="per_visit_fee" 
                                       value="{{ old('per_visit_fee', $session->per_visit_fee) }}"
                                       min="0"
                                       placeholder="Contoh: 20000"
                                       class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       required>
                            </div>
                            @error('per_visit_fee')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <textarea id="notes"
                                          name="notes" 
                                          rows="3"
                                          placeholder="Catatan tambahan tentang sesi ini..."
                                          class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $session->notes) }}</textarea>
                            </div>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Player Check-in Section -->
                    <div class="p-6 border-t border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Check-in Pemain</h3>
                        <p class="text-sm text-gray-500 mb-4">Pilih pemain yang akan ikut sesi bermain ini</p>
                        
                        <!-- Search Bar -->
                        <div class="mb-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       id="playerSearch"
                                       placeholder="Cari pemain..." 
                                       class="pl-10 w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       onkeyup="filterPlayers()">
                            </div>
                        </div>

                        <!-- Players List -->
                        <div class="max-h-60 overflow-y-auto border border-gray-200 rounded-lg">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2 p-3">
                                @php
                                    // Get all active players sorted alphabetically
                                    $allPlayers = \App\Models\Player::where('is_active', true)
                                        ->orderBy('name', 'asc')
                                        ->get();
                                    
                                    // Get checked-in players for this session
                                    $checkedInPlayerIds = $session->attendances->pluck('player_id')->toArray();
                                @endphp
                                
                                @foreach($allPlayers as $player)
                                    @php
                                        $isCheckedIn = in_array($player->id, $checkedInPlayerIds);
                                    @endphp
                                    <div class="player-item" data-player-name="{{ strtolower($player->name) }}">
                                        <label class="flex items-center p-2 {{ $isCheckedIn ? 'bg-blue-50 border border-blue-200' : 'bg-gray-50' }} rounded-xl hover:bg-gray-100 cursor-pointer transition-colors">
                                            <input type="checkbox" 
                                                   id="player_{{ $player->id }}"
                                                   name="player_ids[]" 
                                                   value="{{ $player->id }}"
                                                   {{ $isCheckedIn ? 'checked' : '' }}
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mr-2">
                                            <div class="flex-1 min-w-0">
                                                <span class="text-xs font-medium text-gray-800 truncate block">{{ $player->name }}</span>
                                                <span class="text-xs text-gray-500">{{ $player->grade }}</span>
                                                <div class="mt-1">
                                                    @if($player->is_member)
                                                        <span class="px-1 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800">Member</span>
                                                    @else
                                                        <span class="px-1 py-0.5 text-xs rounded-full bg-orange-100 text-orange-800">Non-Member</span>
                                                    @endif
                                                    @if($isCheckedIn)
                                                        <span class="ml-1 px-1 py-0.5 text-xs rounded-full bg-green-100 text-green-800">Checked-in</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Selected Players Summary -->
                        <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-medium text-blue-800">Pemain Dipilih: <span id="selectedCount">0</span></h4>
                                <button type="button" 
                                        onclick="clearAllPlayers()"
                                        class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    Hapus Semua
                                </button>
                            </div>
                            <div id="selectedPlayersList" class="mt-2 text-sm text-blue-700">
                                <!-- Selected players will be shown here -->
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 p-6 bg-gray-50 border-t border-gray-100">
                        <a href="{{ route('sessions.show', $session) }}" 
                           class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
// Store selected players data
let selectedPlayers = [];

// Toggle player selection
function togglePlayer(playerId, playerName, isMember) {
    const checkbox = document.getElementById(`player_${playerId}`);
    const isChecked = checkbox.checked;
    
    if (isChecked) {
        // Add to selected players
        selectedPlayers.push({
            id: playerId,
            name: playerName,
            is_member: isMember
        });
    } else {
        // Remove from selected players
        selectedPlayers = selectedPlayers.filter(p => p.id !== playerId);
    }
    
    updateSelectedDisplay();
}

// Update selected players display
function updateSelectedDisplay() {
    const countElement = document.getElementById('selectedCount');
    const listElement = document.getElementById('selectedPlayersList');
    
    countElement.textContent = selectedPlayers.length;
    
    if (selectedPlayers.length > 0) {
        const playerNames = selectedPlayers.map(p => 
            `${p.name} ${p.is_member ? '(Member)' : '(Non-Member)'}`
        ).join(', ');
        listElement.innerHTML = `<strong>${playerNames}</strong>`;
    } else {
        listElement.innerHTML = '';
    }
}

// Filter players based on search
function filterPlayers() {
    const searchInput = document.getElementById('playerSearch');
    const searchTerm = searchInput.value.toLowerCase();
    const playerItems = document.querySelectorAll('.player-item');
    
    playerItems.forEach(item => {
        const playerName = item.dataset.playerName;
        if (playerName.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

// Clear all selected players
function clearAllPlayers() {
    // Uncheck all checkboxes
    const checkboxes = document.querySelectorAll('input[name="player_ids[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Clear selected players array
    selectedPlayers = [];
    
    // Update display
    updateSelectedDisplay();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to checkboxes
    const checkboxes = document.querySelectorAll('input[name="player_ids[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const playerId = this.value;
            const playerItem = this.closest('.player-item');
            const playerName = playerItem.querySelector('.font-medium').textContent;
            const isMember = playerItem.querySelector('.bg-blue-100') !== null;
            
            togglePlayer(playerId, playerName, isMember);
        });
    });
    
    // Pre-select existing players if any
    @php
        $existingPlayerIds = old('player_ids', []);
        if (!empty($existingPlayerIds)) {
            echo "const existingIds = [" . implode(',', $existingPlayerIds) . "];\n";
            echo "existingIds.forEach(id => {\n";
            echo "    const checkbox = document.getElementById(`player_${id}`);\n";
            echo "    if (checkbox) {\n";
            echo "        checkbox.checked = true;\n";
            echo "        const playerItem = checkbox.closest('.player-item');\n";
            echo "        const playerName = playerItem.querySelector('.font-medium').textContent;\n";
            echo "        const isMember = playerItem.querySelector('.bg-blue-100') !== null;\n";
            echo "        selectedPlayers.push({ id: id, name: playerName, is_member: isMember });\n";
            echo "    }\n";
            echo "});\n";
            echo "updateSelectedDisplay();\n";
        }
    @endphp
});
</script>
