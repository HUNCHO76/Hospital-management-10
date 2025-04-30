<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_no',
      'FullName',
      'age',
       'gender',
      'marital_status',
      'phone',
       'occupation',
      'country',
      'payment_method'
    ];
}
