<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PlayerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Player::query();
        
        // Filter by search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Filter by grade
        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }
        
        // Filter by status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }
        
        // Sort: active players first, then by name
        $players = $query->orderBy('is_active', 'desc')
                          ->orderBy('name', 'asc')
                          ->paginate(10);
        
        return view('players.index', compact('players'));
    }

    public function show(Player $player): View
    {
        $player->load(['sessionAttendances.session', 'matchPlayers.match.session', 'financialTransactions']);
        return view('players.show', compact('player'));
    }

    public function create(): View
    {
        return view('players.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:players,name',
            'phone' => 'nullable|string|max:20',
            'grade' => 'required|in:A,B,C,D',
            'is_member' => 'boolean',
            'is_active' => 'boolean',
        ]);

        Player::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'grade' => $request->grade,
            'is_member' => $request->boolean('is_member'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('players.index')
            ->with('success', 'Pemain berhasil ditambahkan.');
    }

    public function edit(Player $player): View
    {
        return view('players.edit', compact('player'));
    }

    public function update(Request $request, Player $player): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:players,name,' . $player->id,
            'phone' => 'nullable|string|max:20',
            'grade' => 'required|in:A,B,C,D',
            'is_member' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);

        // Handle checkbox values properly - check if they exist in request
        $isMember = $request->has('is_member') ? 1 : 0;
        $isActive = $request->has('is_active') ? 1 : 0;

        $player->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'grade' => $validated['grade'],
            'is_member' => $isMember,
            'is_active' => $isActive,
        ]);

        return redirect()->route('players.index')
            ->with('success', 'Data pemain berhasil diperbarui.');
    }

    public function destroy(Player $player): RedirectResponse
    {
        $player->delete();

        return redirect()->route('players.index')
            ->with('success', 'Pemain berhasil dihapus.');
    }
}
