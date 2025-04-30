<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\Auth\RegisteredUserController;

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


Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
        Route::post('/edit/{id?}', [PrescriptionController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [PrescriptionController::class, 'destroy'])->name('delete');
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
        Route::post('/edit/{id?}', [AdmissionController::class, 'update'])->name('update');
        Route::get('/delete/{id?}', [AdmissionController::class, 'destroy'])->name('delete');
    });



require __DIR__.'/auth.php';
