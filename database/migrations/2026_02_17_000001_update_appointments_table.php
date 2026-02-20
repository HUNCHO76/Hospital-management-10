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
        Schema::table('appointments', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('appointments', 'end_time')) {
                $table->time('end_time')->nullable()->after('appointment_date');
            }
            if (!Schema::hasColumn('appointments', 'reason')) {
                $table->string('reason')->nullable()->after('status');
            }
            if (!Schema::hasColumn('appointments', 'reminder_sent')) {
                $table->boolean('reminder_sent')->default(false)->after('reason');
            }
            if (!Schema::hasColumn('appointments', 'cancellation_reason')) {
                $table->text('cancellation_reason')->nullable()->after('reminder_sent');
            }
            if (!Schema::hasColumn('appointments', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable()->after('cancellation_reason');
            }
            if (!Schema::hasColumn('appointments', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop columns if they exist
            $table->dropColumn([
                'end_time',
                'reason',
                'reminder_sent',
                'cancellation_reason',
                'cancelled_at',
                'deleted_at'
            ]);
        });
    }
};
