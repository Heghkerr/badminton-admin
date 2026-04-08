<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_date',
        'location',
        'courts_count',
        'scoring_target',
        'per_visit_fee',
        'notes',
    ];

    protected $casts = [
        'session_date' => 'date',
    ];

    public function attendances(): HasMany
    {
        return $this->hasMany(SessionAttendance::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(GameMatch::class, 'session_id');
    }

    public function financialTransactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class);
    }
}
