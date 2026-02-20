<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'checkup_id',
        'order_date',
        'status',
        'notes',
        'viewed_at',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'viewed_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function checkup()
    {
        return $this->belongsTo(checkup::class, 'checkup_id');
    }

    public function items()
    {
        return $this->hasMany(LabOrderItem::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
