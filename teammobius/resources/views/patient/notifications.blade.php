@extends('layouts.patient')

@section('content')

@php
    $notifications = [
        ['title'=>'Appointment Confirmed', 'type'=>'appointment', 'is_read'=>false],
        ['title'=>'Remember to drink water!', 'type'=>'health', 'is_read'=>true],
    ];
@endphp

<h2 class="fw-bold mb-4" style="color:#002147;">Notifications</h2>

@foreach($notifications as $note)
    <div class="card p-3 mb-2 shadow-sm {{ $note['is_read'] ? '' : 'border-primary' }}">
        <h5>{{ $note['title'] }}</h5>
        <p class="text-muted mb-0">Type: {{ ucfirst($note['type']) }}</p>
    </div>
@endforeach

@endsection
