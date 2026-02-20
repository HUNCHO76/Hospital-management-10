<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'FirstName',
        'MiddleName',
        'LastName',
        'email',
        'password',
        'Role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function doctor()
    {
        return $this->hasMany(Doctor::class);
    }

    public function uploadedDocuments()
    {
        return $this->hasMany(PatientDocument::class, 'uploaded_by');
    }

    /**
     * Get the user's role in lowercase for routing
     */
    public function getRoleAttribute($value)
    {
        return $value;
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role)
    {
        return strtolower($this->attributes['Role'] ?? '') === strtolower($role);
    }

    public function enteredLabOrderItems()
    {
        return $this->hasMany(LabOrderItem::class, 'entered_by');
    }

    public function createdInvoices()
    {
        return $this->hasMany(Invoice::class, 'cashier_id');
    }

    public function receivedPayments()
    {
        return $this->hasMany(Payment::class, 'cashier_id');
    }
}