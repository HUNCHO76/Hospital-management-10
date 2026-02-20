<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineSupplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'contact_email',
        'contact_phone',
        'address',
        'city',
        'country',
        'payment_terms',
        'delivery_days',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function batches()
    {
        return $this->hasMany(MedicineBatch::class);
    }

    public function orders()
    {
        return $this->hasMany(MedicineOrder::class);
    }
}
