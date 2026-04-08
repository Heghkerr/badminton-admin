<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Periode Membership</h2>
            <a href="{{ route('membership-periods.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium">
                Buat Periode
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
                <div class="p-5 sm:p-6">
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biaya</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($periods as $period)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $period->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            {{ $period->start_date->format('d M Y') }} - {{ $period->end_date->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Rp {{ number_format($period->fee_amount, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-right text-sm">
                                            <a href="{{ route('financial.membership-payments', ['membership_period_id' => $period->id]) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                                Kelola Pembayaran
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada periode membership</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="sm:hidden divide-y divide-gray-100">
                        @forelse($periods as $period)
                            <div class="py-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="text-sm font-semibold text-gray-900">{{ $period->name }}</div>
                                        <div class="mt-1 text-xs text-gray-500">{{ $period->start_date->format('d M Y') }} - {{ $period->end_date->format('d M Y') }}</div>
                                        <div class="mt-2 text-sm font-bold text-gray-900">Rp {{ number_format($period->fee_amount, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="shrink-0">
                                        <a href="{{ route('financial.membership-payments', ['membership_period_id' => $period->id]) }}" class="inline-flex items-center justify-center px-3 py-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 text-sm font-medium">
                                            Kelola
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-10 text-center text-gray-500">Belum ada periode membership</div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $periods->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
