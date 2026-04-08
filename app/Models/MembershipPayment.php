<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_period_id',
        'player_id',
        'status',
        'paid_at',
        'amount',
        'financial_transaction_id',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function membershipPeriod(): BelongsTo
    {
        return $this->belongsTo(MembershipPeriod::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function financialTransaction(): BelongsTo
    {
        return $this->belongsTo(FinancialTransaction::class);
    }
}
