<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'checkup_id',
        'status',
        'percentage',
        'remarks',
    ];
    public function checkup()
    {
        return $this->belongsTo(checkup::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
