<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'insurance_provider',
        'policy_number',
        'claim_number',
        'total_claimed',
        'approved_amount',
        'status',
        'submitted_at',
        'approved_at',
        'notes',
    ];

    protected $casts = [
        'total_claimed' => 'decimal:2',
        'approved_amount' => 'decimal:2',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
