# Role-Based Dashboard System

## Overview
The Hospital Management System now has a fully functional role-based dashboard system. Users are automatically redirected to their role-specific dashboard upon login.

## Available Roles and Dashboards

| Role | Database Value | Dashboard Route | Controller |
|------|---------------|-----------------|------------|
| Admin | `admin` | `/admin-dashboard` | AdminDashboardController |
| Doctor | `doctor` | `/doctor-dashboard` | DoctorDashboardController |
| Nurse | `nurse` | `/nurse-dashboard` | NurseDashboardController |
| Pharmacist | `pharmacist` | `/pharmacist-dashboard` | PharmacistDashboardController |
| Receptionist | `receptionist` | `/receptionist-dashboard` | ReceptionistDashboardController |
| Lab Technician | `Lab Technician` | `/lab-dashboard` | LabTechnicianDashboardController |
| Cashier | `cashier` | `/cashier-dashboard` | CashierDashboardController |
| Patient | `patient` | `/patient-dashboard` | PatientDashboardController |
| Local | `local` | `/old-dashboard` | DashboardController (default) |

## How It Works

### 1. **User Model** (`app/Models/User.php`)
- Added `Role` to fillable fields
- Added `hasRole()` method for role checking
- Role field is stored with capital 'R' in database

### 2. **Role Middleware** (`app/Http/Middleware/RoleMiddleware.php`)
- Protects routes based on user role
- Case-insensitive role comparison
- Registered as `'role'` in Http/Kernel.php

### 3. **Dashboard Routing** (`routes/web.php`)
- Main `/dashboard` route redirects based on user role
- Each role has its own protected route group
- Uses `match()` expression for clean role-based redirection

### 4. **Dashboard Views** (`resources/views/dashboards/`)
Each role has a customized dashboard view:
- `admin.blade.php` - System administration overview
- `doctor.blade.php` - Patient appointments and medical management
- `nurse.blade.php` - Patient care and vital signs
- `pharmacist.blade.php` - Pharmacy inventory and prescriptions
- `receptionist.blade.php` - Patient registration and appointments
- `lab.blade.php` - Laboratory tests and results
- `cashier.blade.php` - Billing and payments
- `patient.blade.php` - Personal medical records and appointments

### 5. **Dashboard Controllers** (`app/Http/Controllers/`)
Each dashboard controller provides role-specific statistics and data:
- Filters data based on user role
- Provides relevant metrics for each role
- Returns appropriate dashboard view with stats

## Role Assignment

To assign a role to a user, update the `Role` field in the users table:

```sql
UPDATE users SET Role = 'doctor' WHERE email = 'doctor@hospital.com';
UPDATE users SET Role = 'nurse' WHERE email = 'nurse@hospital.com';
UPDATE users SET Role = 'admin' WHERE email = 'admin@hospital.com';
```

## Features by Role

### Admin Dashboard
- Total users, patients, appointments, doctors
- User management
- System permissions
- System logs

### Doctor Dashboard
- Appointments today
- Total assigned patients
- Pending appointments
- Patient list access
- Prescription writing
- Lab test ordering

### Nurse Dashboard
- Pre-tests today
- Active admissions
- Patients to monitor
- Vital signs recording
- Ward rounds
- Patient monitoring

### Pharmacist Dashboard
- Total inventory
- Pending prescriptions
- Low stock alerts
- Inventory management
- Prescription dispensing
- Supplier orders

### Receptionist Dashboard
- Patients registered today
- Appointments booked today
- Pending appointments
- Patient registration
- Appointment scheduling
- Room management

### Lab Technician Dashboard
- Pending analyses
- Tests completed
- Laboratory patients
- Sample collection
- Result entry
- Equipment management

### Cashier Dashboard
- Revenue today
- Unpaid invoices
- Total invoices
- Invoice creation
- Payment collection
- Revenue reports

### Patient Dashboard
- Upcoming appointments
- Medical records
- Outstanding bills
- Appointment viewing
- Medical record access
- Bill payment

## Default Dashboard
Users with role `local` or no assigned role see a default dashboard with a notification to contact the administrator for role assignment.

## Security

- All role-specific routes are protected by the `role` middleware
- Unauthorized access attempts result in a 403 error
- Authentication is required for all dashboard access
- Role checking is case-insensitive for flexibility

## Testing Role-Based Access

1. Log in as a user
2. Check your assigned role in the database
3. You'll be automatically redirected to your role-specific dashboard
4. Try accessing another role's dashboard - you'll get a 403 error

## Customization

To add a new role:

1. Add role to database enum in migration
2. Create dashboard controller (e.g., `NewRoleDashboardController`)
3. Create dashboard view (e.g., `dashboards/newrole.blade.php`)
4. Add route in `routes/web.php`:
   ```php
   'newrole' => redirect()->route('newrole.dashboard'),
   ```
5. Add protected route group:
   ```php
   Route::middleware(['role:newrole'])->prefix('newrole-dashboard')->group(function () {
       Route::get('/', [NewRoleDashboardController::class, 'index'])->name('newrole.dashboard');
   });
   ```

## Troubleshooting

### User not redirected to role dashboard
- Check if Role field is set in database
- Verify role value matches exactly (case-insensitive)
- Clear application cache: `php artisan cache:clear`

### 403 Forbidden error
- User role doesn't match required role for route
- Check middleware protection in routes
- Verify RoleMiddleware is registered in Kernel.php

### Dashboard shows wrong data
- Check dashboard controller logic
- Verify user relationship queries
- Test with different user accounts
