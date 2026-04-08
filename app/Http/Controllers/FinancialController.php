<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use App\Models\MembershipPayment;
use App\Models\MembershipPeriod;
use App\Models\Player;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class FinancialController extends Controller
{
    public function index(Request $request): View
    {
        $query = FinancialTransaction::with(['player', 'session', 'membershipPeriod'])
            ->orderBy('txn_date', 'desc');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('date_from')) {
            $query->where('txn_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('txn_date', '<=', $request->date_to);
        }

        $transactions = $query->paginate(20);

        $incomeQuery = FinancialTransaction::where('type', 'income')
            ->when($request->filled('date_from'), function($q) use ($request) {
                return $q->where('txn_date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function($q) use ($request) {
                return $q->where('txn_date', '<=', $request->date_to);
            });

        $totalIncome = (clone $incomeQuery)->sum('amount');

        $incomeByMethod = (clone $incomeQuery)
            ->selectRaw('method, SUM(amount) as total')
            ->groupBy('method')
            ->pluck('total', 'method');

        $incomeCash = (int) ($incomeByMethod['Cash'] ?? 0);
        $incomeTransfer = (int) ($incomeByMethod['Transfer'] ?? 0);

        $totalExpense = FinancialTransaction::where('type', 'expense')
            ->when($request->filled('date_from'), function($q) use ($request) {
                return $q->where('txn_date', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function($q) use ($request) {
                return $q->where('txn_date', '<=', $request->date_to);
            })
            ->sum('amount');

        $netAmount = $totalIncome - $totalExpense;

        return view('financial.index', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'netAmount',
            'incomeCash',
            'incomeTransfer'
        ));
    }

    public function membershipPayments(Request $request): View
    {
        $membershipPeriods = MembershipPeriod::orderBy('start_date', 'desc')->get();

        $selectedPeriodId = $request->integer('membership_period_id') ?: ($membershipPeriods->first()->id ?? null);
        $selectedPeriod = $selectedPeriodId
            ? MembershipPeriod::with('payments.player', 'payments.financialTransaction')->find($selectedPeriodId)
            : null;

        $members = Player::where('is_member', true)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $paymentByPlayerId = collect();
        if ($selectedPeriod) {
            $paymentByPlayerId = $selectedPeriod->payments->keyBy('player_id');
        }

        $memberCount = $members->count();

        return view('financial.membership-payments', compact(
            'membershipPeriods',
            'selectedPeriod',
            'members',
            'paymentByPlayerId',
            'memberCount'
        ));
    }

    public function recordMembershipPayment(Request $request): RedirectResponse
    {
        $request->validate([
            'membership_period_id' => 'required|exists:membership_periods,id',
            'player_id' => 'required|exists:players,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
        ]);

        $membershipPeriod = MembershipPeriod::findOrFail($request->membership_period_id);
        $player = Player::findOrFail($request->player_id);

        $existingPayment = MembershipPayment::where('membership_period_id', $membershipPeriod->id)
            ->where('player_id', $player->id)
            ->first();

        if ($existingPayment) {
            return redirect()->route('financial.membership-payments', ['membership_period_id' => $membershipPeriod->id])
                ->with('success', 'Pembayaran membership sudah tercatat sebelumnya.');
        }

        $financialTransaction = FinancialTransaction::create([
            'txn_date' => now(),
            'type' => 'income',
            'category' => 'Membership Fee',
            'amount' => $request->amount,
            'method' => $request->payment_method,
            'notes' => "Membership payment for {$player->name} - {$membershipPeriod->name}",
            'player_id' => $player->id,
            'membership_period_id' => $membershipPeriod->id,
        ]);

        MembershipPayment::create([
            'membership_period_id' => $membershipPeriod->id,
            'player_id' => $player->id,
            'status' => 'paid',
            'paid_at' => now(),
            'amount' => $request->amount,
            'financial_transaction_id' => $financialTransaction->id,
        ]);

        return redirect()->route('financial.membership-payments', ['membership_period_id' => $membershipPeriod->id])
            ->with('success', 'Pembayaran membership berhasil dicatat.');
    }
}
