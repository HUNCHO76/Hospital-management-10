<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Core hospital structure
        $this->call([
            DepartmentSeeder::class,
            RoomSeeder::class,
            UserSeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
            DoctorPatientSeeder::class,
            
            // Clinical operations
            DiseaseSeeder::class,
            LabTestSeeder::class,
            BillingSettingSeeder::class,
            PretestSeeder::class,
            AppointmentSeeder::class,
            CheckupSeeder::class,
            LabOrderSeeder::class,
            LabOrderItemSeeder::class,
            CheckupDiseaseSeeder::class,
            MedicalRecordSeeder::class,
            SampleTestResultSeeder::class,
            
            // Pharmacy operations
            MedicineSeeder::class,
            MedicineBatchSeeder::class,
            MedicineOrderSeeder::class,
            
            // Billing and records
            BillSeeder::class,
            PrescriptionSeeder::class,
            AdmissionSeeder::class,
            
            // Communications
            NotificationSeeder::class,
        ]);
    }
}
