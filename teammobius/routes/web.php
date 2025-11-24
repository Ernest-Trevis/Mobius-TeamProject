<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', function() {
    return redirect('/signin');
});

Route::get('/signup', [AuthController::class, 'showSignUp'])->name('signup.form');
Route::post('/signup', [AuthController::class, 'register'])->name('signup.submit');

Route::get('/signin', [AuthController::class, 'showSignIn'])->name('signin.form');
Route::post('/signin', [AuthController::class, 'login'])->name('signin.submit');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// --- PROTECTED ROUTES (Requires Login) ---
Route::middleware(['auth'])->group(function () {
    
    // --- PATIENT-SPECIFIC VIEWS ---
    Route::get('/my-profile', [PatientController::class, 'showPatientProfile'])->name('patient.profile');
    Route::get('/my-appointments', [AppointmentController::class, 'showPatientAppointments'])->name('patient.appointments');
    Route::get('/my-records', [MedicalRecordController::class, 'showPatientRecords'])->name('patient.records');

    // --- ADMIN/DOCTOR VIEWS ---
    Route::middleware(['role:admin,doctor,patient'])->group(function () {
        
        // --- PATIENT MANAGEMENT (CRUD) ---
        Route::resource('patients', PatientController::class);

        // --- APPOINTMENT MANAGEMENT (CRUD) ---
        Route::resource('appointments', AppointmentController::class);

        // ---BOOKING OF APPOINTMENTS---
        Route::get('/booking', [AppointmentController::class, 'bookingIndex'])->name('booking.index');
        Route::post('/booking', [AppointmentController::class, 'bookAppointment'])->name('booking.book');
        
        // --- MEDICAL RECORD MANAGEMENT (Nested Resource) ---
        Route::resource('patients.records', MedicalRecordController::class)->except(['index']);
        
        // --- PRESCRIPTION MANAGEMENT (Nested Resource for adding/editing prescriptions) ---
        Route::resource('records.prescriptions', PrescriptionController::class)->only(['index', 'store', 'update', 'destroy']);
    });
});
