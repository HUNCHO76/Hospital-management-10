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
        Schema::create('patient_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('medical_record_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('document_type', [
                'lab_report',
                'xray',
                'ct_scan',
                'ultrasound',
                'prescription',
                'discharge_summary',
                'pathology_report',
                'other'
            ])->default('other');
            $table->string('file_name');
            $table->string('file_path');
            $table->bigInteger('file_size');
            $table->string('mime_type');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('restrict');
            $table->timestamp('upload_date')->useCurrent();
            $table->text('description')->nullable();
            $table->boolean('is_confidential')->default(false);
            $table->timestamps();

            // Indexes for performance
            $table->index('patient_id');
            $table->index('medical_record_id');
            $table->index('document_type');
            $table->index('upload_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_documents');
    }
};
