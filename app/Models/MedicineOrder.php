<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'supplier_id',
        'order_date',
        'expected_delivery_date',
        'actual_delivery_date',
        'total_amount',
        'status',
        'ordered_by',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'expected_delivery_date' => 'date',
        'actual_delivery_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(MedicineSupplier::class);
    }

    public function items()
    {
        return $this->hasMany(MedicineOrderItem::class);
    }

    public function orderedBy()
    {
        return $this->belongsTo(User::class, 'ordered_by');
    }

    public function getTotalItemsAttribute()
    {
        return $this->items()->sum('quantity');
    }

    public function getReceivedItemsAttribute()
    {
        return $this->items()->where('received_quantity', '>', 0)->count();
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'processing']);
    }
}
