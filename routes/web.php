<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\PatientController;

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

require __DIR__.'/auth.php';
