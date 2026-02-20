<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InsuranceClaim;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'patient_id',
        'cashier_id',
        'invoice_date',
        'due_date',
        'subtotal',
        'discount_type',
        'discount_value',
        'discount_amount',
        'tax_rate',
        'tax_amount',
        'total_amount',
        'paid_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'datetime',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function insuranceClaim()
    {
        return $this->hasOne(InsuranceClaim::class);
    }

    public function getBalanceAttribute(): float
    {
        return max(0, (float) $this->total_amount - (float) $this->paid_amount);
    }

    public function refreshPaymentStatus(): void
    {
        $paid = (float) $this->paid_amount;
        $total = (float) $this->total_amount;

        if ($this->status === 'cancelled' || $this->status === 'refunded') {
            return;
        }

        if ($paid <= 0) {
            $this->status = $this->status === 'draft' ? 'draft' : 'pending';
        } elseif ($paid < $total) {
            $this->status = 'partially_paid';
        } else {
            $this->status = 'paid';
        }

        $this->save();
    }
}
