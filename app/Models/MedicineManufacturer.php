<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineManufacturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country',
        'contact_email',
        'contact_phone',
        'address',
        'license_number',
    ];

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
