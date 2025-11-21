@extends('layouts.patient')

@section('content')

@php
    $doctors = [
        [
            'name'=>'Dr. Kimani',
            'specialization'=>'General Physician',
            'experience'=> 12
        ],
        [
            'name'=>'Dr. Achieng',
            'specialization'=>'Dentist',
            'experience'=> 7
        ]
    ];
@endphp

<h2 class="fw-bold mb-4" style="color:#002147;">Available Doctors</h2>

@foreach($doctors as $doc)
    <div class="card mb-3 shadow-sm p-3">
        <h5>{{ $doc['name'] }}</h5>
        <p class="mb-1"><strong>Specialization:</strong> {{ $doc['specialization'] }}</p>
        <p class="mb-1"><strong>Experience:</strong> {{ $doc['experience'] }} years</p>

        <button class="btn btn-primary btn-sm mt-2">Book Appointment</button>
    </div>
@endforeach

@endsection
