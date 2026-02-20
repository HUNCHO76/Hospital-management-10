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
        Schema::table('medical_records', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('medical_records', 'notes')) {
                $table->longText('notes')->nullable()->after('treatment');
            }
            if (!Schema::hasColumn('medical_records', 'vital_signs')) {
                $table->json('vital_signs')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('medical_records', 'allergies')) {
                $table->json('allergies')->nullable()->after('vital_signs');
            }
            if (!Schema::hasColumn('medical_records', 'chronic_conditions')) {
                $table->json('chronic_conditions')->nullable()->after('allergies');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn([
                'notes',
                'vital_signs',
                'allergies',
                'chronic_conditions'
            ]);
        });
    }
};
