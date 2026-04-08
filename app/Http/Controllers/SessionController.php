<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\SessionAttendance;
use App\Models\Player;
use App\Models\GameMatch;
use App\Models\MatchPlayer;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class SessionController extends Controller
{
    public function index(): View
    {
        $sessions = Session::with('attendances.player')
            ->orderBy('session_date', 'desc')
            ->paginate(10);
        
        return view('sessions.index', compact('sessions'));
    }

    public function create(): View
    {
        return view('sessions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'session_date' => 'required|date',
            'location' => 'required|string|max:255',
            'courts_count' => 'required|integer|min:1',
            'scoring_target' => 'nullable|integer|min:1',
            'per_visit_fee' => 'required|integer|min:0',
            'notes' => 'nullable|string',
            'player_ids' => 'nullable|array',
            'player_ids.*' => 'exists:players,id',
        ]);

        $session = Session::create([
            'session_date' => $request->session_date,
            'location' => $request->location,
            'courts_count' => $request->courts_count,
            'scoring_target' => $request->scoring_target ?? 21,
            'per_visit_fee' => $request->per_visit_fee,
            'notes' => $request->notes,
        ]);

        // Check-in selected players from the form
        $checkedInCount = 0;
        if ($request->has('player_ids')) {
            foreach ($request->player_ids as $playerId) {
                $player = Player::findOrFail($playerId);
                
                $data = [
                    'session_id' => $session->id,
                    'player_id' => $playerId,
                    'checked_in_at' => now(),
                    'played_count' => 0,
                    'per_visit_fee_amount' => $player->is_member ? 0 : $session->per_visit_fee,
                    'per_visit_payment_status' => $player->is_member ? 'paid' : 'unpaid',
                ];

                if (Schema::hasColumn('session_attendances', 'per_visit_fee_paid')) {
                    $data['per_visit_fee_paid'] = $player->is_member;
                }

                SessionAttendance::create($data);
                $checkedInCount++;
            }
        }

        $message = $checkedInCount > 0 
            ? "Sesi bermain berhasil dibuat. {$checkedInCount} pemain berhasil check-in."
            : "Sesi bermain berhasil dibuat. Tidak ada pemain yang di-check-in.";

        return redirect()->route('sessions.show', $session)
            ->with('success', $message);
    }

    public function show(Session $session): View
    {
        $session->load(['attendances.player', 'matches.matchPlayers.player']);
        
        // Sort attendances by player name alphabetically
        $attendances = $session->attendances->sortBy(function($attendance) {
            return strtolower($attendance->player->name);
        });
        
        // Reassign sorted attendances back to session
        $session->setRelation('attendances', $attendances);
        
        $players = Player::where('is_active', true)
            ->orderBy('grade')
            ->orderBy('name')
            ->get();

        $ongoingPlayerIds = MatchPlayer::whereHas('match', function ($query) use ($session) {
                $query->where('session_id', $session->id)
                    ->where('status', 'ongoing');
            })
            ->pluck('player_id')
            ->unique()
            ->values()
            ->all();

        $occupiedCourts = GameMatch::where('session_id', $session->id)
            ->where('status', 'ongoing')
            ->pluck('court_no')
            ->unique()
            ->values()
            ->all();

        return view('sessions.show', compact('session', 'players', 'ongoingPlayerIds', 'occupiedCourts'));
    }

    public function edit(Session $session): View
    {
        return view('sessions.edit', compact('session'));
    }

    public function update(Request $request, Session $session): RedirectResponse
    {
        $request->validate([
            'session_date' => 'required|date',
            'location' => 'required|string|max:255',
            'courts_count' => 'required|integer|min:1',
            'scoring_target' => 'nullable|integer|min:1',
            'per_visit_fee' => 'required|integer|min:0',
            'notes' => 'nullable|string',
            'player_ids' => 'nullable|array',
            'player_ids.*' => 'exists:players,id',
        ]);

        // Update session data
        $session->update([
            'session_date' => $request->session_date,
            'location' => $request->location,
            'courts_count' => $request->courts_count,
            'scoring_target' => $request->scoring_target ?? 21,
            'per_visit_fee' => $request->per_visit_fee,
            'notes' => $request->notes,
        ]);

        // Handle player check-ins
        if ($request->has('player_ids')) {
            $checkedInCount = 0;
            
            foreach ($request->player_ids as $playerId) {
                // Check if player is already checked in
                $existingAttendance = SessionAttendance::where('session_id', $session->id)
                    ->where('player_id', $playerId)
                    ->first();

                if (!$existingAttendance) {
                    $player = Player::findOrFail($playerId);

                    $data = [
                        'session_id' => $session->id,
                        'player_id' => $playerId,
                        'checked_in_at' => now(),
                        'played_count' => 0,
                        'per_visit_fee_amount' => $player->is_member ? 0 : $session->per_visit_fee,
                        'per_visit_payment_status' => $player->is_member ? 'paid' : 'unpaid',
                    ];

                    if (Schema::hasColumn('session_attendances', 'per_visit_fee_paid')) {
                        $data['per_visit_fee_paid'] = false;
                    }

                    SessionAttendance::create($data);
                    $checkedInCount++;
                }
            }

            if ($checkedInCount > 0) {
                return redirect()->route('sessions.show', $session)
                    ->with('success', "Sesi bermain berhasil diperbarui. {$checkedInCount} pemain berhasil ditambahkan.");
            }
        }

        return redirect()->route('sessions.show', $session)
            ->with('success', 'Sesi bermain berhasil diperbarui.');
    }

    public function destroy(Session $session): RedirectResponse
    {
        $session->delete();

        return redirect()->route('sessions.index')
            ->with('success', 'Sesi bermain berhasil dihapus.');
    }

    public function checkInPlayer(Request $request, Session $session): RedirectResponse
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
        ]);

        $player = Player::findOrFail($request->player_id);

        $data = [
            'checked_in_at' => now(),
            'played_count' => SessionAttendance::where('session_id', $session->id)
                ->where('player_id', $player->id)
                ->value('played_count') ?? 0,
            'per_visit_fee_amount' => $player->is_member ? 0 : $session->per_visit_fee,
            'per_visit_payment_status' => $player->is_member ? 'paid' : 'unpaid',
        ];

        if (Schema::hasColumn('session_attendances', 'per_visit_fee_paid')) {
            $data['per_visit_fee_paid'] = $player->is_member;
        }

        $attendance = SessionAttendance::updateOrCreate(
            [
                'session_id' => $session->id,
                'player_id' => $player->id,
            ],
            $data
        );

        return redirect()->route('sessions.show', $session)
            ->with('success', "{$player->name} berhasil check-in.");
    }

    public function bulkCheckIn(Request $request, Session $session): RedirectResponse
    {
        $request->validate([
            'player_ids' => 'required|array',
            'player_ids.*' => 'exists:players,id',
        ]);

        $checkedInCount = 0;
        foreach ($request->player_ids as $playerId) {
            $player = Player::findOrFail($playerId);
            
            // Skip if already checked in
            if (SessionAttendance::where('session_id', $session->id)
                ->where('player_id', $playerId)
                ->exists()) {
                continue;
            }

            $data = [
                'session_id' => $session->id,
                'player_id' => $playerId,
                'checked_in_at' => now(),
                'played_count' => 0,
                'per_visit_fee_amount' => $session->per_visit_fee,
                'per_visit_payment_status' => 'unpaid',
            ];

            if (Schema::hasColumn('session_attendances', 'per_visit_fee_paid')) {
                $data['per_visit_fee_paid'] = false;
            }

            SessionAttendance::create($data);

            $checkedInCount++;

        }

        return redirect()->route('sessions.show', $session)
            ->with('success', "{$checkedInCount} pemain berhasil check-in.");
    }

    public function removePlayer(Request $request, Session $session): RedirectResponse
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
        ]);

        $attendance = SessionAttendance::where('session_id', $session->id)
            ->where('player_id', $request->player_id)
            ->first();

        if ($attendance) {
            $playerName = $attendance->player->name;
            $attendance->delete();

            return redirect()->route('sessions.show', $session)
                ->with('success', "{$playerName} berhasil dikeluarkan dari sesi.");
        }

        return redirect()->route('sessions.show', $session)
            ->with('error', 'Pemain tidak ditemukan dalam sesi ini.');
    }

    public function checkout(Session $session, SessionAttendance $attendance): RedirectResponse
    {
        // Verify the attendance belongs to the session
        if ($attendance->session_id !== $session->id) {
            abort(404);
        }

        // Delete the attendance record
        $attendance->delete();

        return redirect()->route('sessions.show', $session)
            ->with('success', 'Pemain berhasil check-out dari sesi.');
    }

    public function generatePairs(Request $request, Session $session): RedirectResponse
    {
        $occupiedCourts = GameMatch::where('session_id', $session->id)
            ->where('status', 'ongoing')
            ->pluck('court_no')
            ->unique()
            ->values()
            ->all();

        $freeCourtsCount = max(0, (int) $session->courts_count - count($occupiedCourts));
        if ($freeCourtsCount <= 0) {
            return redirect()->route('sessions.show', $session)
                ->with('error', 'Semua lapangan masih dipakai. Selesaikan pertandingan dulu sebelum buat rekomendasi baru.');
        }

        $ongoingPlayerIds = MatchPlayer::whereHas('match', function ($query) use ($session) {
                $query->where('session_id', $session->id)
                    ->where('status', 'ongoing');
            })
            ->pluck('player_id')
            ->unique()
            ->values()
            ->all();

        $attendances = SessionAttendance::with('player')
            ->where('session_id', $session->id)
            ->whereNotIn('player_id', $ongoingPlayerIds)
            ->whereHas('player', function ($query) {
                $query->where('is_active', true);
            })
            ->get();

        if ($attendances->count() < 4) {
            return redirect()->route('sessions.show', $session)
                ->with('error', 'Minimal 4 pemain (yang tidak sedang bermain) diperlukan untuk membuat rekomendasi pasangan.');
        }

        // Get existing pairs from session
        $existingPairs = session('pairs', []);
        
        // Create new pairs
        $newPairs = $this->createBalancedPairs($attendances, $freeCourtsCount);
        
        // Append new pairs to existing ones
        $allPairs = array_merge($existingPairs, $newPairs);

        return redirect()->route('sessions.show', $session)
            ->with('pairs', $allPairs)
            ->with('success', 'Rekomendasi pasangan berhasil ditambahkan.');
    }

    public function createMatch(Request $request, Session $session): RedirectResponse
    {
        $request->validate([
            'team1_player1' => 'required|exists:players,id',
            'team1_player2' => 'required|exists:players,id|different:team1_player1',
            'team2_player1' => 'required|exists:players,id|different:team1_player1,team1_player2',
            'team2_player2' => 'required|exists:players,id|different:team1_player1,team1_player2,team2_player1',
            'court_no' => 'required|integer|min:1',
        ]);

        // Check if players are checked in
        $playerIds = [
            $request->team1_player1,
            $request->team1_player2,
            $request->team2_player1,
            $request->team2_player2
        ];

        // Prevent using an occupied court
        $courtOccupied = GameMatch::where('session_id', $session->id)
            ->where('status', 'ongoing')
            ->where('court_no', $request->court_no)
            ->exists();
        if ($courtOccupied) {
            return redirect()->route('sessions.show', $session)
                ->with('error', "Lapangan {$request->court_no} masih dipakai. Pilih lapangan lain.")
                ->with('pairs', session('pairs', []));
        }

        // Prevent selecting players who are currently playing
        $ongoingPlayerIds = MatchPlayer::whereHas('match', function ($query) use ($session) {
                $query->where('session_id', $session->id)
                    ->where('status', 'ongoing');
            })
            ->pluck('player_id')
            ->unique()
            ->values()
            ->all();
        foreach ($playerIds as $pid) {
            if (in_array((int) $pid, array_map('intval', $ongoingPlayerIds), true)) {
                return redirect()->route('sessions.show', $session)
                    ->with('error', 'Ada pemain yang sedang bermain. Tidak bisa membuat pertandingan dengan pemain tersebut.')
                    ->with('pairs', session('pairs', []));
            }
        }

        foreach ($playerIds as $playerId) {
            $attendance = SessionAttendance::where('session_id', $session->id)
                ->where('player_id', $playerId)
                ->first();
                
            if (!$attendance) {
                return redirect()->route('sessions.show', $session)
                    ->with('error', 'Semua pemain harus check-in terlebih dahulu.');
            }
        }

        // Create match
        $match = GameMatch::create([
            'session_id' => $session->id,
            'court_no' => $request->court_no,
            'started_at' => now(),
            'status' => 'ongoing',
        ]);

        // Create match players for team 1
        MatchPlayer::create([
            'match_id' => $match->id,
            'player_id' => $request->team1_player1,
            'team_no' => 1,
            'position_no' => 1,
        ]);

        MatchPlayer::create([
            'match_id' => $match->id,
            'player_id' => $request->team1_player2,
            'team_no' => 1,
            'position_no' => 2,
        ]);

        // Create match players for team 2
        MatchPlayer::create([
            'match_id' => $match->id,
            'player_id' => $request->team2_player1,
            'team_no' => 2,
            'position_no' => 1,
        ]);

        MatchPlayer::create([
            'match_id' => $match->id,
            'player_id' => $request->team2_player2,
            'team_no' => 2,
            'position_no' => 2,
        ]);

        // Move players to "bottom of queue" for next recommendation
        SessionAttendance::where('session_id', $session->id)
            ->whereIn('player_id', $playerIds)
            ->update(['last_played_at' => now()]);

        // Preserve existing recommendations in session
        $existingPairs = session('pairs', []);

        return redirect()->route('sessions.show', $session)
            ->with('success', 'Pertandingan berhasil dibuat.')
            ->with('pairs', $existingPairs);
    }

    public function createMultipleMatches(Request $request, Session $session): RedirectResponse
    {
        $pairs = session('pairs', []);
        
        if (empty($pairs)) {
            return redirect()->route('sessions.show', $session)
                ->with('error', 'Tidak ada rekomendasi pasangan untuk dibuat.');
        }

        $createdMatches = 0;
        $occupiedCourts = GameMatch::where('session_id', $session->id)
            ->where('status', 'ongoing')
            ->pluck('court_no')
            ->unique()
            ->values()
            ->all();

        $freeCourts = [];
        for ($i = 1; $i <= $session->courts_count; $i++) {
            if (!in_array($i, $occupiedCourts, true)) {
                $freeCourts[] = $i;
            }
        }

        if (empty($freeCourts)) {
            return redirect()->route('sessions.show', $session)
                ->with('error', 'Semua lapangan masih dipakai. Selesaikan pertandingan dulu sebelum membuat yang baru.')
                ->with('pairs', session('pairs', []));
        }
        
        $usedPlayerIds = [];
        foreach ($pairs as $index => $pair) {
            if ($index >= count($freeCourts)) {
                break;
            }

            $courtNo = $freeCourts[$index];
            
            // Validate all players are checked in
            $playerIds = [
                $pair[0]->player_id,
                $pair[1]->player_id,
                $pair[2]->player_id,
                $pair[3]->player_id
            ];

            if (count(array_intersect($usedPlayerIds, $playerIds)) > 0) {
                continue;
            }

            foreach ($playerIds as $playerId) {
                $attendance = SessionAttendance::where('session_id', $session->id)
                    ->where('player_id', $playerId)
                    ->first();
                    
                if (!$attendance) {
                    continue 2; // Skip this pair if any player not checked in
                }
            }

            // Create match
            $match = GameMatch::create([
                'session_id' => $session->id,
                'court_no' => $courtNo,
                'started_at' => now(),
                'status' => 'ongoing',
            ]);

            // Create match players for team 1
            MatchPlayer::create([
                'match_id' => $match->id,
                'player_id' => $pair[0]->player_id,
                'team_no' => 1,
                'position_no' => 1,
            ]);

            MatchPlayer::create([
                'match_id' => $match->id,
                'player_id' => $pair[1]->player_id,
                'team_no' => 1,
                'position_no' => 2,
            ]);

            // Create match players for team 2
            MatchPlayer::create([
                'match_id' => $match->id,
                'player_id' => $pair[2]->player_id,
                'team_no' => 2,
                'position_no' => 1,
            ]);

            MatchPlayer::create([
                'match_id' => $match->id,
                'player_id' => $pair[3]->player_id,
                'team_no' => 2,
                'position_no' => 2,
            ]);

            SessionAttendance::where('session_id', $session->id)
                ->whereIn('player_id', $playerIds)
                ->update(['last_played_at' => now()]);

            $usedPlayerIds = array_values(array_unique(array_merge($usedPlayerIds, $playerIds)));
            $createdMatches++;
        }

        // Clear recommendations after creating all matches
        session()->forget('pairs');

        return redirect()->route('sessions.show', $session)
            ->with('success', "Berhasil membuat {$createdMatches} pertandingan sekaligus.");
    }

    public function createSelectedMatches(Request $request, Session $session): RedirectResponse
    {
        $request->validate([
            'selected_pairs' => 'required|array',
            'selected_pairs.*' => 'integer|min:0',
        ]);

        $allPairs = session('pairs', []);
        $selectedIndices = $request->selected_pairs;
        
        if (empty($selectedIndices)) {
            return redirect()->route('sessions.show', $session)
                ->with('error', 'Pilih minimal satu pasangan untuk dibuat.');
        }

        $createdMatches = 0;
        $createdPairIndices = [];
        $occupiedCourts = GameMatch::where('session_id', $session->id)
            ->where('status', 'ongoing')
            ->pluck('court_no')
            ->unique()
            ->values()
            ->all();

        $freeCourts = [];
        for ($i = 1; $i <= $session->courts_count; $i++) {
            if (!in_array($i, $occupiedCourts, true)) {
                $freeCourts[] = $i;
            }
        }

        if (empty($freeCourts)) {
            return redirect()->route('sessions.show', $session)
                ->with('error', 'Semua lapangan masih dipakai. Selesaikan pertandingan dulu sebelum membuat yang baru.')
                ->with('pairs', session('pairs', []));
        }
        
        $usedPlayerIds = [];
        foreach ($selectedIndices as $index => $pairIndex) {
            if (!isset($allPairs[$pairIndex])) {
                continue; // Skip invalid indices
            }
            
            $pair = $allPairs[$pairIndex];
            if ($index >= count($freeCourts)) {
                break;
            }
            $courtNo = $freeCourts[$index];
            
            // Validate all players are checked in
            $playerIds = [
                $pair[0]->player_id,
                $pair[1]->player_id,
                $pair[2]->player_id,
                $pair[3]->player_id
            ];

            if (count(array_intersect($usedPlayerIds, $playerIds)) > 0) {
                continue;
            }

            foreach ($playerIds as $playerId) {
                $attendance = SessionAttendance::where('session_id', $session->id)
                    ->where('player_id', $playerId)
                    ->first();
                    
                if (!$attendance) {
                    continue 2; // Skip this pair if any player not checked in
                }
            }

            // Create match
            $match = GameMatch::create([
                'session_id' => $session->id,
                'court_no' => $courtNo,
                'started_at' => now(),
                'status' => 'ongoing',
            ]);

            // Create match players for team 1
            MatchPlayer::create([
                'match_id' => $match->id,
                'player_id' => $pair[0]->player_id,
                'team_no' => 1,
                'position_no' => 1,
            ]);

            MatchPlayer::create([
                'match_id' => $match->id,
                'player_id' => $pair[1]->player_id,
                'team_no' => 1,
                'position_no' => 2,
            ]);

            // Create match players for team 2
            MatchPlayer::create([
                'match_id' => $match->id,
                'player_id' => $pair[2]->player_id,
                'team_no' => 2,
                'position_no' => 1,
            ]);

            MatchPlayer::create([
                'match_id' => $match->id,
                'player_id' => $pair[3]->player_id,
                'team_no' => 2,
                'position_no' => 2,
            ]);

            SessionAttendance::where('session_id', $session->id)
                ->whereIn('player_id', $playerIds)
                ->update(['last_played_at' => now()]);

            $createdMatches++;
            $createdPairIndices[] = $pairIndex;
            $usedPlayerIds = array_values(array_unique(array_merge($usedPlayerIds, $playerIds)));
        }

        // Remove created pairs from recommendations
        $remainingPairs = $allPairs;
        foreach ($createdPairIndices as $pairIndex) {
            if (isset($remainingPairs[$pairIndex])) {
                unset($remainingPairs[$pairIndex]);
            }
        }
        session(['pairs' => array_values($remainingPairs)]);

        return redirect()->route('sessions.show', $session)
            ->with('success', "Berhasil membuat {$createdMatches} pertandingan yang dipilih.");
    }

    public function recordIncidentalPayments(Request $request, Session $session)
    {
        $request->validate([
            'attendances' => 'required|array',
            'attendances.*' => 'exists:session_attendances,id',
            'payment_method' => 'required|string|in:Cash,Transfer,E-Wallet',
        ]);

        $attendancesQuery = SessionAttendance::whereIn('id', $request->attendances)
            ->where('session_id', $session->id);

        if (Schema::hasColumn('session_attendances', 'per_visit_fee_paid')) {
            $attendancesQuery->where('per_visit_fee_paid', false);
        } else {
            $attendancesQuery->where('per_visit_payment_status', '!=', 'paid');
        }

        $attendances = $attendancesQuery->get();

        $processedCount = 0;
        
        foreach ($attendances as $attendance) {
            $amountField = 'amount_' . $attendance->id;
            $amount = $request->input($amountField, $attendance->per_visit_fee_amount);
            
            if ($amount > 0) {
                // Create financial transaction
                $transaction = FinancialTransaction::create([
                    'txn_date' => now(),
                    'type' => 'income',
                    'category' => 'Per Visit Fee',
                    'amount' => $amount,
                    'method' => $request->payment_method,
                    'player_id' => $attendance->player_id,
                    'session_id' => $session->id,
                    'notes' => "Pembayaran per kunjungan untuk sesi {$session->session_date->format('d M Y')} - {$attendance->player->name}",
                ]);

                // Update attendance payment status
                $updateData = [
                    'per_visit_fee_amount' => $amount,
                    'per_visit_payment_status' => 'paid',
                ];

                if (Schema::hasColumn('session_attendances', 'per_visit_fee_paid')) {
                    $updateData['per_visit_fee_paid'] = true;
                }

                $attendance->update($updateData);

                $processedCount++;
            }
        }

        return redirect()->route('sessions.show', $session)
            ->with('success', "Berhasil memproses {$processedCount} pembayaran insidentil.");
    }

    private function createBalancedPairs($attendances, int $maxPairs = 4)
    {
        $pairs = [];
        $playerArray = $attendances->values()->all();

        $gradeStrength = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1];

        // Fairness queue:
        // 1) played_count paling kecil dulu
        // 2) last_played_at paling lama (null = belum pernah main, didahulukan)
        // 3) checked_in_at paling lama (yang paling lama nunggu)
        // 4) random kecil untuk tie-break
        usort($playerArray, function ($a, $b) {
            if (($a->played_count ?? 0) !== ($b->played_count ?? 0)) {
                return ($a->played_count ?? 0) <=> ($b->played_count ?? 0);
            }

            $aLast = $a->last_played_at ? $a->last_played_at->timestamp : 0;
            $bLast = $b->last_played_at ? $b->last_played_at->timestamp : 0;
            if ($aLast !== $bLast) {
                // yang last_played_at lebih kecil (lebih lama) didahulukan
                return $aLast <=> $bLast;
            }

            $aCheck = $a->checked_in_at ? $a->checked_in_at->timestamp : 0;
            $bCheck = $b->checked_in_at ? $b->checked_in_at->timestamp : 0;
            if ($aCheck !== $bCheck) {
                return $aCheck <=> $bCheck;
            }

            return random_int(-1, 1);
        });

        // Helper: pick best pairing for 4 players to balance BOTH teams (and opponents)
        $bestPairingForFour = function (array $g) use ($gradeStrength) {
            $idxOptions = [
                [[0, 1], [2, 3]],
                [[0, 2], [1, 3]],
                [[0, 3], [1, 2]],
            ];

            $scored = [];
            foreach ($idxOptions as $opt) {
                [$t1, $t2] = $opt;
                $t1s = ($gradeStrength[$g[$t1[0]]->player->grade] ?? 0) + ($gradeStrength[$g[$t1[1]]->player->grade] ?? 0);
                $t2s = ($gradeStrength[$g[$t2[0]]->player->grade] ?? 0) + ($gradeStrength[$g[$t2[1]]->player->grade] ?? 0);
                $diff = abs($t1s - $t2s);

                // small penalty if one team becomes very "stacked" (e.g. A+A) when avoidable
                $penalty = 0;
                $t1grades = [$g[$t1[0]]->player->grade, $g[$t1[1]]->player->grade];
                $t2grades = [$g[$t2[0]]->player->grade, $g[$t2[1]]->player->grade];
                if (count(array_unique($t1grades)) === 1 && ($t1grades[0] ?? '') === 'A') {
                    $penalty += 1;
                }
                if (count(array_unique($t2grades)) === 1 && ($t2grades[0] ?? '') === 'A') {
                    $penalty += 1;
                }

                $scored[] = [
                    'opt' => $opt,
                    'score' => ($diff * 10) + $penalty,
                ];
            }

            usort($scored, fn ($x, $y) => $x['score'] <=> $y['score']);

            // Random among equally best options
            $bestScore = $scored[0]['score'];
            $best = array_values(array_filter($scored, fn ($s) => $s['score'] === $bestScore));
            $pick = $best[array_rand($best)]['opt'];

            return $pick;
        };

        $maxPairs = max(1, $maxPairs);
        $pairCount = 0;
        
        while (count($playerArray) >= 4 && $pairCount < $maxPairs) {
            // Ambil 4 teratas dari fairness queue.
            // Ini memastikan pemain yang belum main / paling lama menunggu diprioritaskan.
            $group = array_splice($playerArray, 0, 4);

            $pairing = $bestPairingForFour($group);
            [$t1, $t2] = $pairing;

            // Return in the same 4-item shape used by the view:
            // [team1_p1, team2_p1, team1_p2, team2_p2]
            $pairs[] = [
                $group[$t1[0]],
                $group[$t2[0]],
                $group[$t1[1]],
                $group[$t2[1]],
            ];
            
            $pairCount++;
        }

        return $pairs;
    }

}
