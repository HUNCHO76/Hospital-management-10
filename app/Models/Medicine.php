<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'generic_name',
        'description',
        'category',
        'manufacturer_id',
        'unit_price',
        'strength',
        'route',
        'is_controlled',
        'requires_prescription',
    ];

    protected $casts = [
        'is_controlled' => 'boolean',
        'requires_prescription' => 'boolean',
        'unit_price' => 'decimal:2',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(MedicineManufacturer::class);
    }

    public function inventory()
    {
        return $this->hasOne(MedicineInventory::class);
    }

    public function batches()
    {
        return $this->hasMany(MedicineBatch::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function orderItems()
    {
        return $this->hasMany(MedicineOrderItem::class);
    }

    public function getAvailableStockAttribute()
    {
        return $this->inventory?->available_quantity ?? 0;
    }

    public function getLowStockWarningAttribute()
    {
        return ($this->inventory?->available_quantity ?? 0) <= ($this->inventory?->minimum_stock_level ?? 0);
    }
}
