<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BillController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\CheckupController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PreTestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\DoctorPatientController;
use App\Http\Controllers\CheckupDiseasesController;
use App\Http\Controllers\SampleTestResultsController;
use App\Http\Controllers\PatientDocumentController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AssignedPatientController;
use App\Http\Controllers\DoctorLabOrderController;
use App\Http\Controllers\LabTechnicianLabOrderController;
use App\Http\Controllers\Admin\LabTestController;
use App\Http\Controllers\Cashier\CashierDashboardController as CashierBillingDashboardController;
use App\Http\Controllers\Cashier\CashierBillingController;
use App\Http\Controllers\Cashier\CashierReportController;
use App\Http\Controllers\Admin\Billing\BillingSettingController;
use App\Http\Controllers\Admin\Billing\BillingReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['splade'])->group(function () {
    Route::get('/', fn () => view('home'))->name('home');
    Route::get('/docs', fn () => view('docs'))->name('docs');

    // Registers routes to support the interactive components...
    Route::spladeWithVueBridge();

    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();
});

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DoctorDashboardController;
use App\Http\Controllers\NurseDashboardController;
use App\Http\Controllers\PharmacistDashboardController;
use App\Http\Controllers\ReceptionistDashboardController;
use App\Http\Controllers\LabTechnicianDashboardController;
use App\Http\Controllers\CashierDashboardController;
use App\Http\Controllers\PatientDashboardController;

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $userRole = strtolower($user->Role ?? 'local');
        
        return match($userRole) {
            'admin' => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'),
            'nurse' => redirect()->route('nurse.dashboard'),
            'pharmacist' => redirect()->route('pharmacist.dashboard'),
            'receptionist' => redirect()->route('receptionist.dashboard'),
            'lab technician' => redirect()->route('lab.dashboard.role'),
            'lab_technician' => redirect()->route('lab.dashboard.role'),
            'cashier' => redirect()->route('cashier.dashboard'),
            'patient' => redirect()->route('patient.dashboard'),
            'local' => redirect()->route('old.dashboard'),
            default => redirect()->route('old.dashboard'),
        };
    })->name('dashboard');

    Route::get('/old-dashboard', [DashboardController::class, 'index'])->name('old.dashboard');

    Route::middleware(['role:admin'])->prefix('admin-dashboard')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware(['role:doctor'])->prefix('doctor-dashboard')->group(function () {
        Route::get('/', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');
    });

    Route::middleware(['role:nurse'])->prefix('nurse-dashboard')->group(function () {
        Route::get('/', [NurseDashboardController::class, 'index'])->name('nurse.dashboard');
    });

    Route::middleware(['role:pharmacist'])->prefix('pharmacist-dashboard')->group(function () {
        Route::get('/', [PharmacistDashboardController::class, 'index'])->name('pharmacist.dashboard');
    });

    Route::middleware(['role:receptionist'])->prefix('receptionist-dashboard')->group(function () {
        Route::get('/', [ReceptionistDashboardController::class, 'index'])->name('receptionist.dashboard');
    });

    Route::middleware(['role:Lab Technician,lab_technician'])->prefix('lab-dashboard')->group(function () {
        Route::get('/', [LabTechnicianDashboardController::class, 'index'])->name('lab.dashboard.role');
    });

    Route::middleware(['role:cashier'])->prefix('cashier-dashboard')->group(function () {
        Route::get('/', [CashierDashboardController::class, 'index'])->name('cashier.dashboard');
    });

    Route::middleware(['role:patient'])->prefix('patient-dashboard')->group(function () {
        Route::get('/', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
    });

    Route::get('/AssignedPatient/index', [AssignedPatientController::class, 'index'])->name('assigned_patients');
});
Route::middleware('auth')->prefix('/checkup')->name('checkup.')->group(function () {
    Route::get('/create/{id?}', [CheckupController::class, 'create'])->name('create');
    Route::post('/create', [CheckupController::class, 'store'])->name('store');

    Route::get('/index', [CheckupController::class, 'index'])->name('index');

    Route::get('/show/{id?}', [CheckupController::class, 'show'])->name('show');
    Route::get('/edit/{id?}', [CheckupController::class, 'edit'])->name('edit');
    Route::post('/edit/{id?}', [CheckupController::class, 'update'])->name('update');
    Route::get('/delete/{id?}', [CheckupController::class, 'destroy'])->name('delete');
});

Route::middleware('auth')->prefix('/LabCheckUp')->name('lab.')->group(function(){
    Route::get('/create/{id?}', [SampleTestResultsController::class, 'create'])->name('create');
    Route::post('/create', [SampleTestResultsController::class, 'store'])->name('store');

    Route::get('/index', [SampleTestResultsController::class, 'index'])->name('index');

    Route::get('/show/{id}', [SampleTestResultsController::class, 'show'])->name('show');
    Route::get('/edit/{id}', [SampleTestResultsController::class, 'edit'])->name('edit');
    // Route::post('/edit/{id?}', [CheckupDiseasesController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [SampleTestResultsController::class, 'destroy'])->name('delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('/admin')->name('admin.')->group(function () {
    Route::resource('/user', RegisteredUserController::class);
    Route::resource('/index', UserController::class);
});

Route::middleware('auth')->prefix('/patient')->name('patient.')->group(function(){
    Route::get('/create', [PatientController::class, 'index'])->name('create');
    Route::post('/create', [PatientController::class, 'store'])->name('store');

    Route::get('/index', [PatientController::class, 'show'])->name('index');

    Route::get('/show/{id?}', [PatientController::class, 'show'])->name('show');
    Route::get('/edit/{id?}', [PatientController::class, 'edit'])->name('edit');
    Route::post('/edit/{id?}', [PatientController::class, 'update'])->name('update');
    Route::get('/delete/{id?}', [PatientController::class, 'destroy'])->name('delete');
});
Route::prefix('/department')->name('department.')->group(function () {
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::post('/create', [DepartmentController::class, 'store'])->name('store');

        Route::get('/index', [DepartmentController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [DepartmentController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [DepartmentController::class, 'edit'])->name('edit');
        Route::post('/edit/{id?}', [DepartmentController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [DepartmentController::class, 'destroy'])->name('delete');
    });
 Route::prefix('/doctor')->name('doctor.')->group(function () {
        Route::get('/create', [DoctorController::class, 'create'])->name('create');
        Route::post('/create', [DoctorController::class, 'store'])->name('store');

        Route::get('/index', [DoctorController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [DoctorController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [DoctorController::class, 'edit'])->name('edit');
        Route::post('/edit/{id?}', [DoctorController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [DoctorController::class, 'destroy'])->name('delete');
    });

Route::prefix('/appointment')->name('appointment.')->group(function () {
        Route::get('/create', [AppointmentController::class, 'create'])->name('create');
        Route::post('/create', [AppointmentController::class, 'store'])->name('store');

        Route::get('/index', [AppointmentController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [AppointmentController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [AppointmentController::class, 'edit'])->name('edit');
        Route::post('/edit/{id?}', [AppointmentController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [AppointmentController::class, 'destroy'])->name('delete');
    });

Route::prefix('/prescription')->name('prescription.')->group(function () {
        Route::get('/create', [PrescriptionController::class, 'create'])->name('create');
        Route::post('/create', [PrescriptionController::class, 'store'])->name('store');

        Route::get('/index', [PrescriptionController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [PrescriptionController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [PrescriptionController::class, 'edit'])->name('edit');
        Route::put('/edit/{id?}', [PrescriptionController::class, 'update'])->name('update');
        Route::delete('/delete/{id?}', [PrescriptionController::class, 'destroy'])->name('destroy');
    });

Route::prefix('/bill')->name('bill.')->group(function () {
        Route::get('/create', [BillController::class, 'create'])->name('create');
        Route::post('/create', [BillController::class, 'store'])->name('store');

        Route::get('/index', [BillController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [BillController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [BillController::class, 'edit'])->name('edit');
        Route::post('/edit/{id?}', [BillController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [BillController::class, 'destroy'])->name('delete');
    });

 Route::prefix('/room')->name('room.')->group(function () {
        Route::get('/create', [RoomController::class, 'create'])->name('create');
        Route::post('/create', [RoomController::class, 'store'])->name('store');

        Route::get('/index', [RoomController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [RoomController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [RoomController::class, 'edit'])->name('edit');
        Route::post('/edit/{id?}', [RoomController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [RoomController::class, 'destroy'])->name('delete');
    });

Route::prefix('/admission')->name('admission.')->group(function () {
        Route::get('/create', [AdmissionController::class, 'create'])->name('create');
        Route::post('/create', [AdmissionController::class, 'store'])->name('store');

        Route::get('/index', [AdmissionController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [AdmissionController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [AdmissionController::class, 'edit'])->name('edit');
        Route::put('/edit/{id?}', [AdmissionController::class, 'update'])->name('update');
        Route::delete('/delete/{id?}', [AdmissionController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('/checkup')->name('checkup.')->group(function () {
        Route::get('/create/{id?}', [CheckupController::class, 'create'])->name('create');
        Route::post('/create', [CheckupController::class, 'store'])->name('store');

        Route::get('/index', [CheckupController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [CheckupController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [CheckupController::class, 'edit'])->name('edit');
        Route::post('/edit/{id?}', [CheckupController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [CheckupController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/sample_test_result')->name('sample_test_result.')->group(function () {
        Route::get('/create', [SampleTestResultsController::class, 'create'])->name('create');
        Route::post('/create', [SampleTestResultsController::class, 'store'])->name('store');

        Route::get('/index', [SampleTestResultsController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [SampleTestResultsController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [SampleTestResultsController::class, 'edit'])->name('edit');
        Route::post('/edit/{id?}', [SampleTestResultsController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [SampleTestResultsController::class, 'destroy'])->name('delete');
    });
    Route::prefix('/pre_tests')->name('pre_tests.')->group(function () {
        Route::get('/create/{id?}', [PreTestController::class, 'create'])->name('create');
        Route::post('/create', [PreTestController::class, 'store'])->name('store');

        Route::get('/index', [PreTestController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [PreTestController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [PreTestController::class, 'edit'])->name('edit');
        Route::post('/edit/{id?}', [PreTestController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [PreTestController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/checkup_diseases')->name('checkup_diseases.')->group(function () {
        Route::get('/create', [CheckupDiseasesController::class, 'create'])->name('create');
        Route::post('/create', [CheckupDiseasesController::class, 'store'])->name('store');

        Route::get('/index', [CheckupDiseasesController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [CheckupDiseasesController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [CheckupDiseasesController::class, 'edit'])->name('edit');
        Route::post('/edit/{id?}', [CheckupDiseasesController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [CheckupDiseasesController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/sample_test_results')->name('sample_test_results.')->group(function () {
        Route::get('/create', [SampleTestResultsController::class, 'create'])->name('create');
        Route::post('/create', [SampleTestResultsController::class, 'store'])->name('store');

        Route::get('/index', [SampleTestResultsController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [SampleTestResultsController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [SampleTestResultsController::class, 'edit'])->name('edit');
        Route::post('/edit/{id?}', [SampleTestResultsController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [SampleTestResultsController::class, 'destroy'])->name('delete');
    });

Route::prefix('/doctor_patient')->name('doctor_patient.')->group(function () {
        Route::get('/create{id?}', [DoctorPatientController::class, 'create'])->name('create');
        Route::post('/create', [DoctorPatientController::class, 'store'])->name('store');

        Route::get('/index', [DoctorPatientController::class, 'index'])->name('index');

        Route::get('/show/{id?}', [DoctorPatientController::class, 'show'])->name('show');
        Route::get('/edit/{id?}', [DoctorPatientController::class, 'edit'])->name('edit');
        Route::post('/edit/{id?}', [DoctorPatientController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [DoctorPatientController::class, 'destroy'])->name('delete');

    });

// Patient Documents Routes
Route::middleware('auth')->prefix('/patient-documents')->name('patient-documents.')->group(function () {
    Route::get('/patient/{patient}', [PatientDocumentController::class, 'indexByPatient'])->name('index');
    Route::get('/patient/{patient}/create', [PatientDocumentController::class, 'create'])->name('create');
    Route::post('/patient/{patient}/store', [PatientDocumentController::class, 'store'])->name('store');
    Route::get('/{document}', [PatientDocumentController::class, 'show'])->name('show');
    Route::get('/{document}/preview', [PatientDocumentController::class, 'preview'])->name('preview');
    Route::get('/{document}/download', [PatientDocumentController::class, 'download'])->name('download');
    Route::get('/{document}/edit', [PatientDocumentController::class, 'edit'])->name('edit');
    Route::post('/{document}/update', [PatientDocumentController::class, 'update'])->name('update');
    Route::delete('/{document}', [PatientDocumentController::class, 'destroy'])->name('destroy');
    Route::get('/patient/{patient}/summary', [PatientDocumentController::class, 'getSummary'])->name('summary');
});

// Enhanced Appointment Routes with better REST conventions
Route::middleware('auth')->prefix('/appointments')->name('appointment.')->group(function () {
    Route::get('/', [AppointmentController::class, 'index'])->name('index');
    Route::get('/create', [AppointmentController::class, 'create'])->name('create');
    Route::post('/', [AppointmentController::class, 'store'])->name('store');
    Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('show');
    Route::get('/{appointment}/edit', [AppointmentController::class, 'edit'])->name('edit');
    Route::put('/{appointment}', [AppointmentController::class, 'update'])->name('update');
    Route::post('/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('cancel');
    Route::delete('/{appointment}', [AppointmentController::class, 'destroy'])->name('destroy');
    Route::get('/api/upcoming', [AppointmentController::class, 'getUpcomingAppointments'])->name('upcoming');
    Route::post('/api/send-reminders', [AppointmentController::class, 'sendReminders'])->name('send-reminders');
});

// Pharmacy Management Routes (Pharmacist only)
Route::middleware(['auth', 'role:pharmacist,admin'])->prefix('/pharmacy')->name('pharmacy.')->group(function () {
    Route::get('/dashboard', [PharmacyController::class, 'dashboard'])->name('dashboard');
    Route::get('/inventory', [PharmacyController::class, 'inventory'])->name('inventory');
    Route::get('/batches', [PharmacyController::class, 'batches'])->name('batches');
    Route::get('/orders', [PharmacyController::class, 'orders'])->name('orders');
    Route::get('/orders/create', [PharmacyController::class, 'createOrder'])->name('create-order');
    Route::post('/orders', [PharmacyController::class, 'storeOrder'])->name('store-order');
    Route::post('/orders/{order}/status', [PharmacyController::class, 'updateOrderStatus'])->name('update-status');
    Route::post('/batch/{orderItem}/receive', [PharmacyController::class, 'receiveBatch'])->name('receive-batch');
    Route::post('/dispense', [PharmacyController::class, 'dispenseMedicine'])->name('dispense');
});

// Notification Routes
Route::middleware('auth')->prefix('/notifications')->name('notification.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::post('/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
    Route::get('/api/pending', [NotificationController::class, 'getPending'])->name('pending');
});

// Doctor Lab Orders
Route::middleware(['auth', 'role:doctor'])->prefix('/doctor')->name('doctor.')->group(function () {
    Route::get('/lab-orders', [DoctorLabOrderController::class, 'index'])->name('lab-orders.index');
    Route::get('/lab-orders/create/{checkup?}', [DoctorLabOrderController::class, 'create'])->name('lab-orders.create');
    Route::post('/lab-orders', [DoctorLabOrderController::class, 'store'])->name('lab-orders.store');
    Route::get('/lab-orders/{id}', [DoctorLabOrderController::class, 'show'])->name('lab-orders.show');
    Route::get('/patients/{patient}/lab-results', [DoctorLabOrderController::class, 'patientResults'])->name('patients.lab-results');
});

// Lab Technician Lab Orders
Route::middleware(['auth', 'role:Lab Technician,lab_technician'])->prefix('/lab')->name('labtech.')->group(function () {
    Route::get('/pending-orders', [LabTechnicianLabOrderController::class, 'pendingOrders'])->name('pending');
    Route::get('/orders/completed', [LabTechnicianLabOrderController::class, 'completedOrders'])->name('completed');
    Route::get('/orders/{id}/enter-results', [LabTechnicianLabOrderController::class, 'enterResults'])->name('enter-results');
    Route::put('/orders/{id}/results', [LabTechnicianLabOrderController::class, 'updateResults'])->name('update-results');
});

// Admin Lab Test Catalog
Route::middleware(['auth', 'role:admin'])->prefix('/admin')->name('admin.')->group(function () {
    Route::resource('/lab-tests', LabTestController::class)->except(['show']);
});

// Cashier Billing Module
Route::middleware(['auth', 'role:cashier'])->prefix('/cashier')->name('cashier.')->group(function () {
    Route::get('/dashboard', [CashierBillingDashboardController::class, 'index'])->name('billing-dashboard');
    Route::get('/billing-queue', [CashierBillingController::class, 'queue'])->name('billing-queue');

    Route::get('/invoices/create/{patient?}', [CashierBillingController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [CashierBillingController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{id}', [CashierBillingController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{id}/edit', [CashierBillingController::class, 'edit'])->name('invoices.edit');
    Route::put('/invoices/{id}', [CashierBillingController::class, 'update'])->name('invoices.update');
    Route::get('/invoices/{id}/payment', [CashierBillingController::class, 'paymentForm'])->name('invoices.payment');
    Route::post('/invoices/{id}/payments', [CashierBillingController::class, 'storePayment'])->name('invoices.payments');
    Route::get('/invoices/{id}/print', [CashierBillingController::class, 'print'])->name('invoices.print');

    Route::get('/reports/daily', [CashierReportController::class, 'daily'])->name('reports.daily');
    Route::get('/reports/monthly', [CashierReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/patients/{patient}/billing-history', [CashierBillingController::class, 'patientHistory'])->name('patients.billing-history');
});

// Admin Billing Module
Route::middleware(['auth', 'role:admin'])->prefix('/admin/billing')->name('admin.billing.')->group(function () {
    Route::get('/settings', [BillingSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [BillingSettingController::class, 'update'])->name('settings.update');

    Route::get('/reports', [BillingReportController::class, 'index'])->name('reports.index');
    Route::get('/insurance-claims', [BillingReportController::class, 'insuranceClaims'])->name('insurance-claims.index');
    Route::put('/insurance-claims/{claim}', [BillingReportController::class, 'updateInsuranceClaim'])->name('insurance-claims.update');
});

require __DIR__.'/auth.php';
