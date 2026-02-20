<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'available_quantity',
        'reserved_quantity',
        'minimum_stock_level',
        'maximum_stock_level',
        'reorder_quantity',
        'last_restocked_at',
        'storage_location',
    ];

    protected $casts = [
        'last_restocked_at' => 'datetime',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function getTotalQuantityAttribute()
    {
        return $this->available_quantity + $this->reserved_quantity;
    }

    public function needsReorder()
    {
        return $this->available_quantity <= $this->minimum_stock_level;
    }

    public function getStockPercentageAttribute()
    {
        if ($this->maximum_stock_level == 0) {
            return 0;
        }
        return ($this->available_quantity / $this->maximum_stock_level) * 100;
    }
}
