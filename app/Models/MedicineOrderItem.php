<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_order_id',
        'medicine_id',
        'quantity',
        'received_quantity',
        'unit_price',
        'total_amount',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function medOrder()
    {
        return $this->belongsTo(MedicineOrder::class, 'medicine_order_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function getPendingQuantityAttribute()
    {
        return $this->quantity - $this->received_quantity;
    }

    public function getReceivedPercentageAttribute()
    {
        if ($this->quantity == 0) {
            return 0;
        }
        return ($this->received_quantity / $this->quantity) * 100;
    }
}
