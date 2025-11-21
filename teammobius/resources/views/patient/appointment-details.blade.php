@extends('layouts.patient')

@section('content')

<h2 class="fw-bold" style="color:#002147;">Appointment Details</h2>

<div class="card p-4 shadow-sm mt-3">
    <h4>Dr. Kimani <small class="text-muted">(General Physician)</small></h4>

    <p><strong>Date:</strong> 2025-11-20</p>
    <p><strong>Time:</strong> 09:00 AM</p>
    <p><strong>Status:</strong> <span class="badge bg-success">Confirmed</span></p>

    <hr>

    <h5>Notes:</h5>
    <p>Please come fasting. Bring previous reports.</p>

    <a href="/patient/appointments" class="btn btn-secondary">Back</a>
</div>

@endsection
