<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class checkup_diseases extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_id',
        'disease_name',
        'availability_percentage',
    ];

    public function checkup()
    {
        return $this->belongsTo(checkup::class);
    }
}
