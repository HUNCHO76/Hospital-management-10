<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_id',
        'type',
        'channel',
        'title',
        'message',
        'data',
        'sent_at',
        'status',
        'retry_count',
        'last_error',
    ];

    protected $casts = [
        'data' => 'json',
        'sent_at' => 'datetime',
    ];

    const TYPE_APPOINTMENT = 'appointment';
    const TYPE_PRESCRIPTION = 'prescription';
    const TYPE_LAB_RESULT = 'lab_result';
    const TYPE_BILL = 'bill';
    const TYPE_ADMISSION = 'admission';
    const TYPE_SYSTEM = 'system';

    const CHANNEL_EMAIL = 'email';
    const CHANNEL_SMS = 'sms';
    const CHANNEL_PUSH = 'push';

    const STATUS_PENDING = 'pending';
    const STATUS_SENT = 'sent';
    const STATUS_FAILED = 'failed';
    const STATUS_BOUNCE = 'bounce';

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function canRetry()
    {
        return $this->status === self::STATUS_FAILED && $this->retry_count < 3;
    }

    public function markAsSent()
    {
        $this->update(['status' => self::STATUS_SENT, 'sent_at' => now()]);
    }

    public function markAsFailed($error = null)
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'last_error' => $error,
            'retry_count' => $this->retry_count + 1,
        ]);
    }

    public static function getTypes()
    {
        return [
            self::TYPE_APPOINTMENT => 'Appointment',
            self::TYPE_PRESCRIPTION => 'Prescription',
            self::TYPE_LAB_RESULT => 'Lab Result',
            self::TYPE_BILL => 'Bill',
            self::TYPE_ADMISSION => 'Admission',
            self::TYPE_SYSTEM => 'System',
        ];
    }

    public static function getChannels()
    {
        return [
            self::CHANNEL_EMAIL => 'Email',
            self::CHANNEL_SMS => 'SMS',
            self::CHANNEL_PUSH => 'Push Notification',
        ];
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_SENT => 'Sent',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_BOUNCE => 'Bounce',
        ];
    }
}
