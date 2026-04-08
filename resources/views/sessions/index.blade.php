<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sesi Bermain') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl overflow-hidden">
                <div class="p-5 sm:p-6">
                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Sesi Bermain</h3>
                        <a href="{{ route('sessions.create') }}" 
                           class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium">
                            Buat Sesi Baru
                        </a>
                    </div>

                    <div class="sm:hidden">
                        <div class="divide-y divide-gray-100">
                            @forelse($sessions as $session)
                                <div class="py-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <div class="text-sm font-semibold text-gray-900">{{ $session->session_date->format('d M Y') }}</div>
                                            <div class="mt-1 text-sm text-gray-700 truncate">{{ $session->location }}</div>
                                            <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-gray-600">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                                                    {{ $session->courts_count }} Lapangan
                                                </span>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                                                    {{ $session->attendances->count() }} Pemain
                                                </span>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                                                    {{ $session->matches->count() }} Match
                                                </span>
                                            </div>
                                        </div>
                                        <div class="shrink-0 flex flex-col items-end gap-2">
                                            <a href="{{ route('sessions.show', $session) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Detail
                                            </a>
                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('sessions.edit', $session) }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium">
                                                    Edit
                                                </a>
                                                <form action="{{ route('sessions.destroy', $session) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-10 text-center text-gray-500">
                                    Belum ada sesi bermain
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="hidden sm:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Lokasi
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Lapangan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pemain
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pertandingan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($sessions as $session)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $session->session_date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $session->location }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $session->courts_count }} Lapangan
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $session->attendances->count() }} Pemain
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $session->matches->count() }} Pertandingan
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('sessions.show', $session) }}" 
                                               class="text-blue-600 hover:text-blue-800 mr-3">
                                                Detail
                                            </a>
                                            <a href="{{ route('sessions.edit', $session) }}" 
                                               class="text-amber-600 hover:text-amber-800 mr-3">
                                                Edit
                                            </a>
                                            <form action="{{ route('sessions.destroy', $session) }}" method="POST" 
                                                  class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada sesi bermain
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $sessions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
