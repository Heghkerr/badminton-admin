<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Session;
use App\Models\GameMatch;
use App\Models\SessionAttendance;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        // Get statistics
        $totalPlayers = Player::where('is_active', true)->count();
        $totalMembers = Player::where('is_active', true)->where('is_member', true)->count();
        $totalNonMembers = $totalPlayers - $totalMembers;
        
        $totalSessions = Session::count();
        $activeSession = Session::whereDate('session_date', today())->first();
        
        $totalMatches = GameMatch::count();
        $todayMatches = GameMatch::whereDate('created_at', today())->count();
        
        // Financial statistics
        $totalIncome = FinancialTransaction::where('type', 'income')->sum('amount');
        $totalExpenses = FinancialTransaction::where('type', 'expense')->sum('amount');
        $netIncome = $totalIncome - $totalExpenses;
        
        $todayIncome = FinancialTransaction::where('type', 'income')
            ->whereDate('txn_date', today())
            ->sum('amount');
            
        // Recent activities
        $recentSessions = Session::with('attendances.player')
            ->orderBy('session_date', 'desc')
            ->take(3)
            ->get();
            
        $recentMatches = GameMatch::with('matchPlayers.player')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        // Upcoming sessions
        $upcomingSessions = Session::whereDate('session_date', '>=', today())
            ->orderBy('session_date', 'asc')
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'totalPlayers',
            'totalMembers', 
            'totalNonMembers',
            'totalSessions',
            'activeSession',
            'totalMatches',
            'todayMatches',
            'totalIncome',
            'totalExpenses',
            'netIncome',
            'todayIncome',
            'recentSessions',
            'recentMatches',
            'upcomingSessions'
        ));
    }
}
