<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Total Pemasukan</div>
                            <div class="text-2xl font-bold text-green-600">
                                Rp {{ number_format($totalIncome, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-emerald-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10V6m0 12v-2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Pemasukan Cash</div>
                            <div class="text-2xl font-bold text-emerald-600">
                                Rp {{ number_format($incomeCash ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Pemasukan Transfer</div>
                            <div class="text-2xl font-bold text-indigo-600">
                                Rp {{ number_format($incomeTransfer ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Total Pengeluaran</div>
                            <div class="text-2xl font-bold text-red-600">
                                Rp {{ number_format($totalExpense, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Actions -->
            <div class="bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl mb-6 overflow-hidden">
                <div class="p-5 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Transaksi Keuangan</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('financial.membership-payments') }}" 
                               class="inline-flex items-center justify-center px-3 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 text-sm font-medium">
                                Pembayaran Member
                            </a>
                        </div>
                    </div>

                    <!-- Filters -->
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                            <select name="type" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border">
                                <option value="">Semua</option>
                                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <input type="text" name="category" value="{{ request('category') }}" 
                                   placeholder="Cari kategori..." 
                                   class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                   class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                   class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border">
                        </div>
                        <div class="md:col-span-4">
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-900 text-white rounded-xl hover:bg-slate-800 text-sm font-medium">
                                Filter
                            </button>
                            <a href="{{ route('financial.index') }}" class="ml-2 inline-flex items-center justify-center px-4 py-2.5 border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 text-sm font-medium">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl overflow-hidden">
                <div class="sm:hidden">
                    <div class="divide-y divide-gray-100">
                        @forelse($transactions as $transaction)
                            <div class="p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $transaction->type == 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $transaction->txn_date->format('d M Y') }}</span>
                                        </div>
                                        <div class="mt-1 text-sm font-semibold text-gray-900 truncate">{{ $transaction->category }}</div>
                                        <div class="mt-1 text-xs text-gray-600">
                                            <span class="font-medium">{{ $transaction->method }}</span>
                                            <span class="mx-1">•</span>
                                            <span>{{ $transaction->notes }}</span>
                                        </div>
                                        @if($transaction->player)
                                            <div class="mt-1 text-xs text-gray-500">Pemain: {{ $transaction->player->name }}</div>
                                        @endif
                                    </div>
                                    <div class="shrink-0 text-right">
                                        <div class="text-sm font-bold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500">
                                Belum ada transaksi
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
                                    Tipe
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Metode
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Keterangan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $transaction->txn_date->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $transaction->type == 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $transaction->category }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium 
                                        {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $transaction->method }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div>{{ $transaction->notes }}</div>
                                        @if($transaction->player)
                                            <div class="text-xs text-gray-500">Pemain: {{ $transaction->player->name }}</div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-5 sm:p-6">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
