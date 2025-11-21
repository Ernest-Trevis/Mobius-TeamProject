@extends('layouts.patient')

@section('content')

@php
    // Dummy data for testing (front-end only)
    $doctors = [
        ['name' => 'Dr. Kimani', 'specialization' => 'General Physician'],
        ['name' => 'Dr. Achieng', 'specialization' => 'Dentist'],
    ];

    $appointments = [
        ['doctor'=>'Dr. Kimani', 'date'=>'2025-11-25', 'status'=>'pending'],
        ['doctor'=>'Dr. Achieng', 'date'=>'2025-11-27', 'status'=>'confirmed']
    ];

    $tips = [
        "Drink at least 2 litres of water daily",
        "Brush your teeth twice a day",
        "Take regular walks to improve circulation"
    ];
@endphp

<h2 class="fw-bold mb-4" style="color:#002147;">Dashboard</h2>

@include('patient.components.appointment-form', ['doctors' => $doctors])
@include('patient.components.appointments-list', ['appointments' => $appointments])
@include('patient.components.health-tips', ['tips' => $tips])

@endsection
