<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'txn_date',
        'type',
        'category',
        'amount',
        'method',
        'notes',
        'session_id',
        'player_id',
        'membership_period_id',
    ];

    protected $casts = [
        'txn_date' => 'date',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function membershipPeriod(): BelongsTo
    {
        return $this->belongsTo(MembershipPeriod::class);
    }
}
