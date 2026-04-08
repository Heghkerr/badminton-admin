<?php

namespace App\Http\Controllers;

use App\Models\MembershipPeriod;
use App\Models\MembershipPayment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MembershipPeriodController extends Controller
{
    public function index(): View
    {
        $periods = MembershipPeriod::with('payments.player')
            ->orderBy('start_date', 'desc')
            ->paginate(10);
        
        return view('membership-periods.index', compact('periods'));
    }

    public function create(): View
    {
        return view('membership-periods.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'fee_amount' => 'required|numeric|min:0',
        ]);

        MembershipPeriod::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'fee_amount' => $request->fee_amount,
        ]);

        return redirect()->route('membership-periods.index')
            ->with('success', 'Periode membership berhasil dibuat.');
    }

    public function show(MembershipPeriod $membershipPeriod): View
    {
        $membershipPeriod->load('payments.player');
        
        $players = \App\Models\Player::where('is_member', true)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('membership-periods.show', compact('membershipPeriod', 'players'));
    }

    public function edit(MembershipPeriod $membershipPeriod): View
    {
        return view('membership-periods.edit', compact('membershipPeriod'));
    }

    public function update(Request $request, MembershipPeriod $membershipPeriod): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'fee_amount' => 'required|numeric|min:0',
        ]);

        $membershipPeriod->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'fee_amount' => $request->fee_amount,
        ]);

        return redirect()->route('membership-periods.show', $membershipPeriod)
            ->with('success', 'Periode membership berhasil diperbarui.');
    }

    public function destroy(MembershipPeriod $membershipPeriod): RedirectResponse
    {
        $membershipPeriod->delete();

        return redirect()->route('membership-periods.index')
            ->with('success', 'Periode membership berhasil dihapus.');
    }
}
