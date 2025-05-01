<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_no',
      'full_name',
      'age',
       'gender',
      'marital_status',
      'phone',
       'occupation',
      'country',
      'payment_method'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function preTest()
    {
        return $this->hasMany(Pre_test::class);
    }
    public function doctor()
    {
        return $this->hasMany(Doctor::class);
    }
    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }

}
