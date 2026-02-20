<?php

namespace App\Permission;

/**
 * Authorization helper class for role-based access control
 */
class Authorization
{
    // Define role hierarchies and permissions
    const ROLES = [
        'admin' => 'Administrator',
        'doctor' => 'Doctor',
        'nurse' => 'Nurse',
        'pharmacist' => 'Pharmacist',
        'Lab Technician' => 'Lab Technician',
        'receptionist' => 'Receptionist',
        'cashier' => 'Cashier',
        'local' => 'Patient',
    ];

    const PERMISSIONS = [
        // Admin permissions - full access
        'admin' => [
            'manage_users',
            'manage_doctors',
            'manage_staff',
            'view_all_records',
            'edit_all_records',
            'delete_records',
            'manage_settings',
            'view_analytics',
            'manage_departments',
            'manage_roles',
        ],

        // Doctor permissions
        'doctor' => [
            'view_own_appointments',
            'view_own_patients',
            'create_medical_records',
            'view_medical_records',
            'create_prescriptions',
            'create_diagnoses',
            'upload_documents',
            'view_lab_results',
        ],

        // Nurse permissions
        'nurse' => [
            'view_appointments',
            'view_patients',
            'record_vital_signs',
            'create_checkups',
            'view_medical_records',
            'manage_admissions',
            'manage_rooms',
        ],

        // Pharmacist permissions
        'pharmacist' => [
            'manage_inventory',
            'view_prescriptions',
            'issue_medicines',
            'manage_stock',
            'view_expiry_dates',
            'create_orders',
        ],

        // Lab Technician permissions
        'Lab Technician' => [
            'view_test_orders',
            'create_test_results',
            'manage_equipment',
            'upload_test_results',
        ],

        // Receptionist permissions
        'receptionist' => [
            'manage_appointments',
            'register_patients',
            'view_patient_info',
            'manage_schedules',
        ],

        // Cashier permissions
        'cashier' => [
            'view_bills',
            'create_invoices',
            'process_payments',
            'generate_receipts',
            'view_payment_history',
        ],

        // Patient permissions
        'local' => [
            'view_own_records',
            'view_own_appointments',
            'download_documents',
            'view_prescriptions',
        ],
    ];

    /**
     * Check if user has a specific role
     */
    public static function hasRole($user, $role)
    {
        return $user->Role === $role;
    }

    /**
     * Check if user has any of the given roles
     */
    public static function hasAnyRole($user, array $roles)
    {
        return in_array($user->Role, $roles);
    }

    /**
     * Check if user has a specific permission
     */
    public static function hasPermission($user, $permission)
    {
        $rolePermissions = self::PERMISSIONS[$user->Role] ?? [];
        return in_array($permission, $rolePermissions);
    }

    /**
     * Check if user has any of the given permissions
     */
    public static function hasAnyPermission($user, array $permissions)
    {
        $rolePermissions = self::PERMISSIONS[$user->Role] ?? [];
        foreach ($permissions as $permission) {
            if (in_array($permission, $rolePermissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user has all of the given permissions
     */
    public static function hasAllPermissions($user, array $permissions)
    {
        $rolePermissions = self::PERMISSIONS[$user->Role] ?? [];
        foreach ($permissions as $permission) {
            if (!in_array($permission, $rolePermissions)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get permissions for a role
     */
    public static function getPermissions($role)
    {
        return self::PERMISSIONS[$role] ?? [];
    }

    /**
     * Get all roles with descriptions
     */
    public static function getRoles()
    {
        return self::ROLES;
    }
}
