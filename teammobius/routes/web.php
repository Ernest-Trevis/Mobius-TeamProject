<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PrescriptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PatientController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

// --- PROTECTED ROUTES (Requires Login) ---
Route::middleware(['auth'])->group(function () {
    
    // --- PATIENT-SPECIFIC VIEWS ---
    Route::get('/my-profile', [PatientController::class, 'showPatientProfile'])->name('patient.profile');
    Route::get('/my-appointments', [AppointmentController::class, 'showPatientAppointments'])->name('patient.appointments');
    Route::get('/my-records', [MedicalRecordController::class, 'showPatientRecords'])->name('patient.records');

    // --- ADMIN/DOCTOR VIEWS ---
    Route::middleware(['role:admin,doctor'])->group(function () {
        
        // --- PATIENT MANAGEMENT (CRUD) ---
        Route::resource('patients', PatientController::class);

        // --- APPOINTMENT MANAGEMENT (CRUD) ---
        Route::resource('appointments', AppointmentController::class);
        
        // --- MEDICAL RECORD MANAGEMENT (Nested Resource) ---
        Route::resource('patients.records', MedicalRecordController::class)->except(['index']);
        
        // --- PRESCRIPTION MANAGEMENT (Nested Resource for adding/editing prescriptions) ---
        Route::resource('records.prescriptions', PrescriptionController::class)->only(['store', 'update', 'destroy']);
    });
});
