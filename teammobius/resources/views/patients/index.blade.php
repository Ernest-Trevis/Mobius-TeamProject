@extends('layouts.app')

@section('title', 'Patients')

@section('content')
    <header style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <div>
            <h1 style="margin:0">Patients</h1>
            <div style="color:#6b7280">All registered patients</div>
        </div>

        <div style="display:flex;gap:0.6rem;align-items:center">
            <form method="GET" action="{{ route('patients.index') }}" style="display:flex;gap:.5rem;align-items:center">
                <input name="q" value="{{ $q ?? '' }}" placeholder="Search patients..."
                    style="padding:.6rem;border-radius:8px;border:1px solid #e6edf3">
                <button type="submit"
                    style="background:var(--primary);color:#fff;border:none;padding:.6rem .9rem;border-radius:8px;cursor:pointer">Search</button>
            </form>
            <a href="{{ route('signup.form') }}"
                style="background:var(--accent);color:#fff;padding:.6rem .9rem;border-radius:8px;text-decoration:none">Add
                Patient</a>
        </div>
    </header>

    <section style="margin-bottom:1rem">
        @if ($patients->isEmpty())
            <div class="panel">
                <h2 style="margin-top:0">No patients found</h2>
                <p style="color:#6b7280">You can add a new patient using the button above.</p>
            </div>
        @else
            <div class="panel">
                <table style="width:100%;border-collapse:collapse">
                    <thead>
                        <tr style="text-align:left;color:#6b7280">
                            <th style="padding:.6rem .5rem">Name</th>
                            <th style="padding:.6rem .5rem">Email</th>
                            <th style="padding:.6rem .5rem">Phone</th>
                            <th style="padding:.6rem .5rem">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $p)
                            <tr>
                                <td style="padding:.6rem .5rem">{{ $p->first_name }} {{ $p->last_name }}</td>
                                <td style="padding:.6rem .5rem"><a href="mailto:{{ $p->email }}"
                                        style="color:var(--primary)">{{ $p->email }}</a></td>
                                <td style="padding:.6rem .5rem">{{ $p->phone ?? '—' }}</td>
                                <td style="padding:.6rem .5rem">{{ $p->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top:1rem;display:flex;justify-content:flex-end">
                    {{ $patients->links() }}
                </div>
            </div>
        @endif
    </section>
@endsection
