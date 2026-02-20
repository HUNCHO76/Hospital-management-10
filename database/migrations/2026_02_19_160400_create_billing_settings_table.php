<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billing_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('tax_rate', 8, 2)->default(0);
            $table->string('invoice_prefix')->default('INV');
            $table->unsignedInteger('next_invoice_number')->default(1);
            $table->decimal('default_consultation_fee', 12, 2)->default(10000);
            $table->decimal('default_lab_test_fee', 12, 2)->default(15000);
            $table->decimal('default_room_daily_fee', 12, 2)->default(25000);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_settings');
    }
};
