<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Pemain Baru
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
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="bg-blue-100 rounded-full p-2 mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Pemain</h3>
                            <p class="text-sm text-gray-500">Masukkan data pemain baru</p>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-6">
                    <form action="{{ route('players.store') }}" method="POST">
                        @csrf

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-medium">Perhatian:</span>
                                </div>
                                <ul class="list-disc list-inside text-sm space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-6">
                            <!-- Nama Pemain -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Pemain <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           class="w-full px-4 py-2 pl-10 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                           placeholder="Masukkan nama lengkap"
                                           required>
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}"
                                           class="w-full px-4 py-2 pl-10 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                           placeholder="08123456789">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Grade dan Status -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="grade" class="block text-sm font-medium text-gray-700 mb-2">
                                        Grade <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select id="grade" 
                                                name="grade" 
                                                class="w-full px-4 py-2 pl-10 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none"
                                                required>
                                            <option value="">Pilih Grade</option>
                                            <option value="A" {{ old('grade') == 'A' ? 'selected' : '' }}>Grade A</option>
                                            <option value="B" {{ old('grade') == 'B' ? 'selected' : '' }}>Grade B</option>
                                            <option value="C" {{ old('grade') == 'C' ? 'selected' : '' }}>Grade C</option>
                                            <option value="D" {{ old('grade') == 'D' ? 'selected' : '' }}>Grade D</option>
                                        </select>
                                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <svg class="w-5 h-5 text-gray-400 absolute right-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Membership
                                    </label>
                                    <div class="space-y-2">
                                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                            <input type="radio" name="is_member" value="1" {{ old('is_member', '0') == '1' ? 'checked' : '' }} class="mr-3 text-blue-600">
                                            <div>
                                                <div class="font-medium text-gray-800">Member</div>
                                                <div class="text-sm text-gray-500">Pemain berlangganan</div>
                                            </div>
                                        </label>
                                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                            <input type="radio" name="is_member" value="0" {{ old('is_member', '0') == '0' ? 'checked' : '' }} class="mr-3 text-blue-600">
                                            <div>
                                                <div class="font-medium text-gray-800">Non-Member</div>
                                                <div class="text-sm text-gray-500">Pemain per kunjungan</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Aktif -->
                            <div>
                                <label class="flex items-center p-4 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100 transition-colors">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} class="mr-3 text-blue-600">
                                    <div>
                                        <div class="font-medium text-gray-800">Pemain Aktif</div>
                                        <div class="text-sm text-gray-500">Centang jika pemain masih aktif bermain</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('players.index') }}" 
                               class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Pemain
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
