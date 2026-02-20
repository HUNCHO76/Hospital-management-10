<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_order_id',
        'lab_test_id',
        'result_value',
        'result_text',
        'file_path',
        'entered_by',
        'entered_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'entered_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(LabOrder::class, 'lab_order_id');
    }

    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }

    public function enteredBy()
    {
        return $this->belongsTo(User::class, 'entered_by');
    }

    public function isAbnormal(): bool
    {
        if (empty($this->result_value) || empty($this->labTest?->reference_range)) {
            return false;
        }

        if (!is_numeric($this->result_value)) {
            return false;
        }

        $range = str_replace(' ', '', $this->labTest->reference_range);

        if (preg_match('/^(-?\d+(?:\.\d+)?)\s*[-–]\s*(-?\d+(?:\.\d+)?)$/', $range, $matches)) {
            $value = (float) $this->result_value;
            $min = (float) $matches[1];
            $max = (float) $matches[2];

            return $value < $min || $value > $max;
        }

        if (preg_match('/^<\s*(-?\d+(?:\.\d+)?)$/', $range, $matches)) {
            return (float) $this->result_value >= (float) $matches[1];
        }

        if (preg_match('/^>\s*(-?\d+(?:\.\d+)?)$/', $range, $matches)) {
            return (float) $this->result_value <= (float) $matches[1];
        }

        return false;
    }
}
