@extends('layouts.patient')

@section('content')

@php
    $appointments = [
        [
            'doctor' => 'Dr. Kimani',
            'specialty' => 'General Physician',
            'date' => '2025-11-20',
            'time' => '09:00 AM',
            'status' => 'confirmed'
        ],
        [
            'doctor' => 'Dr. Achieng',
            'specialty' => 'Dentist',
            'date' => '2025-11-25',
            'time' => '11:00 AM',
            'status' => 'pending'
        ]
    ];
@endphp

<h2 class="fw-bold mb-4" style="color:#002147;">My Appointments</h2>

@foreach($appointments as $appt)
    <div class="card mb-3 shadow-sm p-3">
        <h5>{{ $appt['doctor'] }} <small class="text-muted">({{ $appt['specialty'] }})</small></h5>

        <p class="mb-1"><strong>Date:</strong> {{ $appt['date'] }}</p>
        <p class="mb-1"><strong>Time:</strong> {{ $appt['time'] }}</p>

        <span class="badge {{ $appt['status']=='pending' ? 'bg-warning' : 'bg-success' }}">
            {{ ucfirst($appt['status']) }}
        </span>

        <a href="/patient/appointments/1" class="btn btn-primary btn-sm mt-3">View Details</a>
    </div>
@endforeach

@endsection
