<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'player_id',
        'checked_in_at',
        'played_count',
        'last_played_at',
        'per_visit_fee_amount',
        'per_visit_fee_paid',
        'per_visit_payment_status',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'last_played_at' => 'datetime',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
