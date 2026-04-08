<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\MembershipPeriodController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('players', PlayerController::class);
    Route::resource('sessions', SessionController::class);
    Route::post('/sessions/{session}/bulk-check-in', [SessionController::class, 'bulkCheckIn'])->name('sessions.bulk-check-in');
    Route::post('/sessions/{session}/generate-pairs', [SessionController::class, 'generatePairs'])->name('sessions.generate-pairs');
    Route::post('/sessions/{session}/create-match', [SessionController::class, 'createMatch'])->name('sessions.create-match');
    Route::post('/sessions/{session}/create-multiple-matches', [SessionController::class, 'createMultipleMatches'])->name('sessions.create-multiple-matches');
    Route::post('/sessions/{session}/create-selected-matches', [SessionController::class, 'createSelectedMatches'])->name('sessions.create-selected-matches');
    Route::delete('/sessions/{session}/attendances/{attendance}', [SessionController::class, 'checkout'])->name('sessions.checkout');
    Route::delete('/sessions/{session}/remove-player', [SessionController::class, 'removePlayer'])->name('sessions.remove-player');
    Route::resource('matches', MatchController::class);
    Route::post('/matches/{match}/update-score', [MatchController::class, 'updateScore'])->name('matches.update-score');
    Route::post('/matches/{match}/complete', [MatchController::class, 'complete'])->name('matches.complete');
    Route::post('/matches/{match}/end', [MatchController::class, 'endMatch'])->name('matches.end');
    Route::resource('membership-periods', MembershipPeriodController::class);

    // Backward-compatible alias (some views/links may still reference the old name)
    Route::get('/membership-period/create', [MembershipPeriodController::class, 'create'])->name('membership-period.create');
    Route::get('/membership-periode', [MembershipPeriodController::class, 'index'])->name('membership-periode.index');
    
    Route::prefix('financial')->name('financial.')->group(function () {
        Route::get('/', [FinancialController::class, 'index'])->name('index');

        // Keep these static routes BEFORE the {transaction} parameter route
        Route::get('/membership-payments', [FinancialController::class, 'membershipPayments'])->name('membership-payments');
        Route::post('/record-membership-payment', [FinancialController::class, 'recordMembershipPayment'])->name('record-membership-payment');
    });
    
    Route::post('/sessions/{session}/check-in', [SessionController::class, 'checkInPlayer'])->name('sessions.check-in');
    Route::post('/sessions/{session}/generate-pairs', [SessionController::class, 'generatePairs'])->name('sessions.generate-pairs');
    Route::post('/sessions/{session}/record-incidental-payments', [SessionController::class, 'recordIncidentalPayments'])->name('sessions.record-incidental-payments');
    Route::post('/sessions/{session}/create-match', [SessionController::class, 'createMatch'])->name('sessions.create-match');
    Route::post('/matches/{match}/end', [MatchController::class, 'endMatch'])->name('matches.end');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
