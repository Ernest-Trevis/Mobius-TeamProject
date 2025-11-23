@extends('layouts.welcome')
@section('title', 'Sign Up')


@section('content')
    <h2>Create an Account</h2>


    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST" action="{{ route('signup.submit') }}">
        @csrf


        <div class="form-row">
            <input name="firstName" placeholder="First Name" value="{{ old('firstName') }}" required>
            <input name="lastName" placeholder="Last Name" value="{{ old('lastName') }}" required>
        </div>


        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
        <input type="tel" name="phone" placeholder="Phone Number" value="{{ old('phone') }}">


        <select name="role" required>
            <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Patient</option>
            <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>


        <input type="date" name="dob" value="{{ old('dob') }}">
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>


        <button type="submit">Sign Up</button>
    </form>


    <p class="text-small">Already have an account? <a href="{{ route('signin.form') }}" class="link">Sign In</a></p>
@endsection
