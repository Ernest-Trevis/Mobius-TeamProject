@extends('layouts.patient')

@section('content')

<h2 class="fw-bold mb-4" style="color:#002147;">Profile Settings</h2>

<form class="card p-4 shadow-sm">

    <label class="form-label">First Name</label>
    <input type="text" class="form-control mb-3" value="John">

    <label class="form-label">Last Name</label>
    <input type="text" class="form-control mb-3" value="Doe">

    <label class="form-label">Email</label>
    <input type="email" class="form-control mb-3" value="johndoe@example.com">

    <label class="form-label">Phone</label>
    <input type="text" class="form-control mb-3" value="0712345678">

    <button class="btn btn-primary">Save Changes</button>

</form>

@endsection
