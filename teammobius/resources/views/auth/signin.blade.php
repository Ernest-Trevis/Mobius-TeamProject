@extends('layouts.welcome')
@section('title', 'Sign In')


@section('content')
    <h2>Welcome Back</h2>


    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST" action="{{ route('signin.submit') }}">
        @csrf


        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Password" required>


        <label class="remember">
            <input type="checkbox" name="remember" id="remember">
            <span>Remember me</span>
        </label>



        <button type="submit">Sign In</button>
    </form>


    <p class="text-small">Don't have an account? <a href="{{ route('signup.form') }}" class="link">Sign Up</a></p>
@endsection
