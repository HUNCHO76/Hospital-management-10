<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'specialization',
        'qualification',
        'department_id',
        'phone',
        'address',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
    
}
