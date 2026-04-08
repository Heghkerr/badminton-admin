<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\MatchPlayer;
use App\Models\SessionAttendance;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MatchController extends Controller
{
    public function index(): View
    {
        $matches = GameMatch::with(['session', 'matchPlayers.player'])
            ->orderBy('started_at', 'desc')
            ->paginate(15);
        
        return view('matches.index', compact('matches'));
    }

    public function show(GameMatch $match): View
    {
        $match->load(['session', 'matchPlayers.player']);
        
        $team1Players = $match->matchPlayers->where('team_no', 1);
        $team2Players = $match->matchPlayers->where('team_no', 2);
        
        return view('matches.show', compact('match', 'team1Players', 'team2Players'));
    }

    public function edit(GameMatch $match): View
    {
        $match->load(['session', 'matchPlayers.player']);
        
        $team1Players = $match->matchPlayers->where('team_no', 1);
        $team2Players = $match->matchPlayers->where('team_no', 2);
        
        return view('matches.edit', compact('match', 'team1Players', 'team2Players'));
    }

    public function update(Request $request, GameMatch $match): RedirectResponse
    {
        $request->validate([
            'team1_score' => 'required|integer|min:0',
            'team2_score' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        // Auto-determine winner based on higher score
        $winnerTeam = null;
        if ($request->team1_score > $request->team2_score) {
            $winnerTeam = 1;
        } elseif ($request->team2_score > $request->team1_score) {
            $winnerTeam = 2;
        }

        $match->update([
            'team1_score' => $request->team1_score,
            'team2_score' => $request->team2_score,
            'winner_team' => $winnerTeam,
            'ended_at' => now(),
            'notes' => $request->notes,
        ]);

        // Increment played_count for all players when match ends
        foreach ($match->matchPlayers as $matchPlayer) {
            SessionAttendance::where('session_id', $match->session_id)
                ->where('player_id', $matchPlayer->player_id)
                ->increment('played_count');
        }

        return redirect()->route('matches.show', $match)
            ->with('success', 'Skor pertandingan berhasil diperbarui.');
    }

    public function destroy(GameMatch $match): RedirectResponse
    {
        $session = $match->session;
        
        foreach ($match->matchPlayers as $matchPlayer) {
            $attendance = SessionAttendance::where('session_id', $session->id)
                ->where('player_id', $matchPlayer->player_id)
                ->first();
            
            if ($attendance && $attendance->played_count > 0) {
                $attendance->decrement('played_count');
            }
        }
        
        $match->delete();

        return redirect()->route('sessions.show', $session)
            ->with('success', 'Pertandingan berhasil dihapus.');
    }

    public function updateScore(Request $request, GameMatch $match): RedirectResponse
    {
        $request->validate([
            'team1_score' => 'required|integer|min:0|max:42',
            'team2_score' => 'required|integer|min:0|max:42',
        ]);

        // Auto-determine winner based on higher score
        $winnerTeam = null;
        if ($request->team1_score > $request->team2_score) {
            $winnerTeam = 1;
        } elseif ($request->team2_score > $request->team1_score) {
            $winnerTeam = 2;
        }

        $match->update([
            'team1_score' => $request->team1_score,
            'team2_score' => $request->team2_score,
            'status' => 'completed',
            'winner_team' => $winnerTeam,
            'ended_at' => now(),
        ]);

        // Increment played_count for all players when match completes
        foreach ($match->matchPlayers as $matchPlayer) {
            SessionAttendance::where('session_id', $match->session_id)
                ->where('player_id', $matchPlayer->player_id)
                ->increment('played_count');
        }

        $winnerText = $winnerTeam ? "Team {$winnerTeam}" : "Seri";
        return redirect()->route('sessions.show', $match->session)
            ->with('success', 'Pertandingan selesai. Pemenang: ' . $winnerText)
            ->with('pairs', session('pairs', []));
    }

    public function complete(Request $request, GameMatch $match): RedirectResponse
    {
        // Auto-determine winner based on current score
        $winnerTeam = null;
        if ($match->team1_score > $match->team2_score) {
            $winnerTeam = 1;
        } elseif ($match->team2_score > $match->team1_score) {
            $winnerTeam = 2;
        }

        $match->update([
            'status' => 'completed',
            'winner_team' => $winnerTeam,
            'ended_at' => now(),
        ]);

        // Increment played_count for all players when match completes
        foreach ($match->matchPlayers as $matchPlayer) {
            SessionAttendance::where('session_id', $match->session_id)
                ->where('player_id', $matchPlayer->player_id)
                ->increment('played_count');
        }

        $winnerText = $winnerTeam ? "Team {$winnerTeam}" : "Seri";
        return redirect()->route('sessions.show', $match->session)
            ->with('success', 'Pertandingan selesai. Pemenang: ' . $winnerText)
            ->with('pairs', session('pairs', []));
    }

    public function endMatch(Request $request, GameMatch $match): RedirectResponse
    {
        $request->validate([
            'team1_score' => 'required|integer|min:0',
            'team2_score' => 'required|integer|min:0',
        ]);

        // Auto-determine winner based on higher score
        $winnerTeam = null;
        if ($request->team1_score > $request->team2_score) {
            $winnerTeam = 1;
        } elseif ($request->team2_score > $request->team1_score) {
            $winnerTeam = 2;
        }

        $match->update([
            'team1_score' => $request->team1_score,
            'team2_score' => $request->team2_score,
            'winner_team' => $winnerTeam,
            'ended_at' => now(),
        ]);

        $winnerText = $winnerTeam ? "Team {$winnerTeam}" : "Seri";
        return redirect()->route('matches.show', $match)
            ->with('success', 'Pertandingan selesai. Pemenang: ' . $winnerText);
    }
}
