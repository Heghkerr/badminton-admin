<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pemain') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('players.update', $player) }}" method="POST">
                        @csrf
                        @method('PATCH')

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
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Nama Pemain <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $player->name) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                       required>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">
                                    Nomor Telepon
                                </label>
                                <input type="text" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $player->phone) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                       placeholder="08123456789">
                            </div>

                            <div>
                                <label for="grade" class="block text-sm font-medium text-gray-700">
                                    Grade <span class="text-red-500">*</span>
                                </label>
                                <select id="grade" 
                                        name="grade" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                                        required>
                                    <option value="">Pilih Grade</option>
                                    <option value="A" {{ old('grade', $player->grade) == 'A' ? 'selected' : '' }}>Grade A</option>
                                    <option value="B" {{ old('grade', $player->grade) == 'B' ? 'selected' : '' }}>Grade B</option>
                                    <option value="C" {{ old('grade', $player->grade) == 'C' ? 'selected' : '' }}>Grade C</option>
                                    <option value="D" {{ old('grade', $player->grade) == 'D' ? 'selected' : '' }}>Grade D</option>
                                </select>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="hidden" name="is_member" value="0">
                                    <input type="checkbox" 
                                           name="is_member"
                                           value="1"
                                           {{ old('is_member', $player->is_member) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Member</span>
                                </label>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" 
                                           name="is_active"
                                           value="1"
                                           {{ old('is_active', $player->is_active) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('players.index') }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update
                            </button>
                        </div>
                    </form>
                    
                    <!-- Delete Form - Separate from Update Form -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-sm font-medium text-red-600">Zone Berbahaya</h3>
                                <p class="text-xs text-gray-500 mt-1">Hapus pemain akan menghapus semua data terkait</p>
                            </div>
                            <form action="{{ route('players.destroy', $player) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pemain ini? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Hapus Pemain
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
