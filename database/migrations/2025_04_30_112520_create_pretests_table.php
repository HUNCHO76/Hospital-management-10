<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pretests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('nurse_id')->constrained('users');
            $table->decimal('height', 5, 2)->nullable();           // e.g., 170.50 cm
            $table->decimal('weight', 5, 2)->nullable();           // e.g., 65.25 kg
            $table->string('blood_pressure')->nullable();         // e.g., "120/80"
            $table->decimal('temperature', 4, 1)->nullable();      // e.g., 36.6
            $table->integer('pulse_rate')->nullable();            // e.g., 72
            $table->integer('respiration_rate')->nullable();      // e.g., 16
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pretests');
    }
};
