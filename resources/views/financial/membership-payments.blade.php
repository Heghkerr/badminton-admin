<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                Pembayaran Membership
            </h2>
            <a href="{{ route('membership-periods.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 text-sm font-medium">
                Buat Periode
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($membershipPeriods->count() === 0)
                <div class="bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl overflow-hidden">
                    <div class="text-center py-12 px-6">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2V12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-500 mb-2">Tidak Ada Periode Membership</h3>
                    <p class="text-sm text-gray-400">Belum ada periode membership yang dibuat.</p>
                    <a href="{{ route('membership-periods.create') }}" 
                       class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 mt-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Periode Membership
                    </a>
                    </div>
                </div>
            @else
                <div class="bg-white shadow-sm ring-1 ring-gray-100 rounded-2xl overflow-hidden mb-6">
                    <div class="p-5 sm:p-6 border-b border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Bulan / Periode</label>
                                <form method="GET" action="{{ route('financial.membership-payments') }}" class="flex gap-2">
                                    <select name="membership_period_id" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border">
                                        @foreach($membershipPeriods as $period)
                                            <option value="{{ $period->id }}" {{ ($selectedPeriod && $selectedPeriod->id === $period->id) ? 'selected' : '' }}>
                                                {{ $period->name }} ({{ $period->start_date->format('d M Y') }} - {{ $period->end_date->format('d M Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-900 text-white rounded-xl hover:bg-slate-800 text-sm font-medium">
                                        Pilih
                                    </button>
                                </form>
                            </div>
                            <div class="md:text-right">
                                <div class="text-sm text-gray-600">Sudah bayar</div>
                                <div class="text-2xl font-bold text-gray-800">
                                    {{ $selectedPeriod ? $selectedPeriod->payments->count() : 0 }} / {{ $memberCount }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($selectedPeriod)
                        <div class="p-5 sm:p-6">
                            <div class="sm:hidden">
                                <div class="divide-y divide-gray-100">
                                    @foreach($members as $member)
                                        @php
                                            $payment = $paymentByPlayerId->get($member->id);
                                        @endphp
                                        <div class="py-4">
                                            <div class="flex items-start justify-between gap-3">
                                                <div class="min-w-0">
                                                    <div class="font-semibold text-gray-900 truncate">{{ $member->name }}</div>
                                                    <div class="mt-0.5 text-xs text-gray-500">Grade {{ $member->grade }}</div>
                                                    <div class="mt-2">
                                                        @if($payment)
                                                            <span class="inline-flex px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Lunas</span>
                                                            <div class="text-xs text-gray-500 mt-1">{{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : '' }}</div>
                                                        @else
                                                            <span class="inline-flex px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Belum</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="shrink-0 text-right">
                                                    <div class="text-sm font-bold text-gray-900">Rp {{ number_format($payment ? $payment->amount : $selectedPeriod->fee_amount, 0, ',', '.') }}</div>
                                                    <div class="text-xs text-gray-500">{{ $payment ? ($payment->financialTransaction->method ?? '-') : '-' }}</div>
                                                </div>
                                            </div>

                                            @if(!$payment)
                                                <form method="POST" action="{{ route('financial.record-membership-payment') }}" class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-2">
                                                    @csrf
                                                    <input type="hidden" name="membership_period_id" value="{{ $selectedPeriod->id }}">
                                                    <input type="hidden" name="player_id" value="{{ $member->id }}">
                                                    <select name="payment_method" class="rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border text-sm">
                                                        <option value="Cash">Cash</option>
                                                        <option value="Transfer">Transfer</option>
                                                        <option value="E-Wallet">E-Wallet</option>
                                                    </select>
                                                    <input type="number" name="amount" min="0" value="{{ $selectedPeriod->fee_amount }}" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2.5 border text-sm">
                                                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 bg-purple-600 text-white rounded-xl hover:bg-purple-700 text-sm font-medium">
                                                        Bayar
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="hidden sm:block overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemain</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($members as $member)
                                            @php
                                                $payment = $paymentByPlayerId->get($member->id);
                                            @endphp
                                            <tr>
                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                    <div class="font-medium">{{ $member->name }}</div>
                                                    <div class="text-xs text-gray-500">Grade {{ $member->grade }}</div>
                                                </td>
                                                <td class="px-4 py-3 text-sm">
                                                    @if($payment)
                                                        <span class="inline-flex px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Lunas</span>
                                                        <div class="text-xs text-gray-500 mt-1">{{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : '' }}</div>
                                                    @else
                                                        <span class="inline-flex px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Belum</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                    {{ $payment ? ($payment->financialTransaction->method ?? '-') : '-' }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                    Rp {{ number_format($payment ? $payment->amount : $selectedPeriod->fee_amount, 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-3 text-right">
                                                    @if(!$payment)
                                                        <form method="POST" action="{{ route('financial.record-membership-payment') }}" class="flex justify-end gap-2">
                                                            @csrf
                                                            <input type="hidden" name="membership_period_id" value="{{ $selectedPeriod->id }}">
                                                            <input type="hidden" name="player_id" value="{{ $member->id }}">
                                                            <select name="payment_method" class="rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border text-sm">
                                                                <option value="Cash">Cash</option>
                                                                <option value="Transfer">Transfer</option>
                                                                <option value="E-Wallet">E-Wallet</option>
                                                            </select>
                                                            <input type="number" name="amount" min="0" value="{{ $selectedPeriod->fee_amount }}" class="w-32 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border text-sm">
                                                            <button type="submit" class="px-3 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 text-sm font-medium">
                                                                Bayar
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-xs text-gray-400">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
