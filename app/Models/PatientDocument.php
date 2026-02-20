<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'medical_record_id',
        'document_type',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
        'uploaded_by',
        'upload_date',
        'description',
        'is_confidential',
    ];

    protected $casts = [
        'upload_date' => 'datetime',
        'is_confidential' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Get document type badge
    public function getDocumentTypeBadgeAttribute()
    {
        $badges = [
            'lab_report' => 'bg-blue-100 text-blue-800',
            'xray' => 'bg-purple-100 text-purple-800',
            'ct_scan' => 'bg-indigo-100 text-indigo-800',
            'ultrasound' => 'bg-pink-100 text-pink-800',
            'prescription' => 'bg-green-100 text-green-800',
            'discharge_summary' => 'bg-yellow-100 text-yellow-800',
            'pathology_report' => 'bg-red-100 text-red-800',
            'other' => 'bg-gray-100 text-gray-800',
        ];

        return $badges[$this->document_type] ?? $badges['other'];
    }

    // Get readable document size
    public function getReadableFileSizeAttribute()
    {
        $bytes = $this->file_size;
        $size = array("B", "kB", "MB", "GB");
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.2f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}
