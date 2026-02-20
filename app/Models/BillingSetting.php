<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax_rate',
        'invoice_prefix',
        'next_invoice_number',
        'default_consultation_fee',
        'default_lab_test_fee',
        'default_room_daily_fee',
    ];

    protected $casts = [
        'tax_rate' => 'decimal:2',
        'next_invoice_number' => 'integer',
        'default_consultation_fee' => 'decimal:2',
        'default_lab_test_fee' => 'decimal:2',
        'default_room_daily_fee' => 'decimal:2',
    ];

    public static function current(): self
    {
        return self::firstOrCreate([], [
            'tax_rate' => 0,
            'invoice_prefix' => 'INV',
            'next_invoice_number' => 1,
            'default_consultation_fee' => 10000,
            'default_lab_test_fee' => 15000,
            'default_room_daily_fee' => 25000,
        ]);
    }
}
