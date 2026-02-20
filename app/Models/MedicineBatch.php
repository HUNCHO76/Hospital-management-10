<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'batch_number',
        'expiry_date',
        'manufacture_date',
        'quantity_received',
        'quantity_available',
        'supplier_id',
        'cost_price',
        'received_at',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'manufacture_date' => 'date',
        'received_at' => 'datetime',
        'cost_price' => 'decimal:2',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function supplier()
    {
        return $this->belongsTo(MedicineSupplier::class);
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiry_date <= now();
    }

    public function getExpiryStatusAttribute()
    {
        $daysUntilExpiry = now()->diffInDays($this->expiry_date);

        if ($daysUntilExpiry < 0) {
            return 'expired';
        } elseif ($daysUntilExpiry <= 30) {
            return 'expiring_soon';
        } else {
            return 'valid';
        }
    }
}
