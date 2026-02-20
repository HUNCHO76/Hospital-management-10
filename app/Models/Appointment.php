<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'end_time',
        'status',
        'reason',
        'notes',
        'reminder_sent',
        'cancellation_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'cancelled_at' => 'datetime',
        'reminder_sent' => 'boolean',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }

    // Scopes for queries
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>', now())
                     ->where('status', '!=', 'cancelled')
                     ->orderBy('appointment_date');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeByDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    public function scopeByPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    // Accessors
    public function getIsUpcomingAttribute()
    {
        return $this->appointment_date > now() && $this->status !== 'cancelled';
    }

    public function getIsPastAttribute()
    {
        return $this->appointment_date < now();
    }
}
