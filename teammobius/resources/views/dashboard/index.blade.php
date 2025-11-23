@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <style>
        :root {
            --primary: #02338D;
            --accent: #E41E26;
            --bg: #f6f8fb;
            --muted: #6b7280;
        }

        body {
            margin: 0;
            background: var(--bg);
            font-family: Poppins, sans-serif;
            color: #111;
        }

        .container {
            max-width: 1100px;
            margin: 2.5rem auto;
            padding: 1rem;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand img {
            height: 100px;
            border-radius: 6px;
        }

        .brand h1 {
            margin: 0;
            color: var(--primary);
            font-size: 1.35rem;
        }

        .small {
            font-size: 0.85rem;
            color: var(--muted);
        }

        .logout-btn {
            background: var(--accent);
            color: #fff;
            padding: 0.6rem 0.9rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .card-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .card {
            background: #fff;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
        }

        .card h3 {
            margin: 0 0 .5rem;
            font-size: 0.95rem;
            color: var(--muted);
        }

        .card .num {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .main {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1rem;
        }

        .panel {
            background: #fff;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
        }

        

        @media(max-width:900px) {
            .card-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .main {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width:600px) {
            .card-row {
                grid-template-columns: 1fr;
            }

            .brand img {
                height: 90px;
            }
        }
    </style>


    <div class="container">

        <!-- Header -->
        <header>
            <div class="brand">
                {{-- Show the large logo only when sidebar is collapsed OR on small screens (optional).
       When the sidebar is visible, you already have the small logo in the sidebar. --}}
                @if (request()->has('show_big_logo') ||
                        (request()->routeIs('dashboard') && request()->cookie('mobius_show_big_logo') == '1'))
                    <img src="/mnt/data/00dc7199-e38d-4abf-a17b-9819c19be17b.png" alt="Logo"
                        style="height:150px;border-radius:6px" class="dashboard-header-logo" />
                @else
                    {{-- Optionally show the logo only when sidebar is collapsed (we check body class via JS; leave empty) --}}
                    <img src="/mnt/data/00dc7199-e38d-4abf-a17b-9819c19be17b.png" alt="Logo"
                        style="height:150px;border-radius:6px; display:none" class="dashboard-header-logo" />
                @endif

                <div>
                    <h1>Mobius Medical</h1>
                    <div class="small">Dashboard</div>
                </div>
            </div>


            <div class="small">
                Signed in as <strong>{{ auth()->user()->first_name }}</strong>

                <form method="POST" action="{{ route('logout') }}" style="display:inline-block; margin-left:10px;">
                    @csrf
                    <button class="logout-btn">Logout</button>
                </form>
            </div>
        </header>


        <!-- Stats -->
        <div class="card-row">
            <div class="card">
                <h3>Total Users</h3>
                <div class="num">{{ $totalUsers }}</div>
            </div>

            <div class="card">
                <h3>Total Patients</h3>
                <div class="num">{{ $totalPatients }}</div>
            </div>

            <div class="card">
                <h3>Total Doctors</h3>
                <div class="num">{{ $totalDoctors }}</div>
            </div>
        </div>


        <!-- Main content -->
        <div class="main">

            <!-- Recent Patients -->
            <div class="panel">
                <h2 style="margin-top:0">Recent Patients</h2>

                @if ($patients->isEmpty())
                    <p class="small">No patients found yet.</p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joined</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($patients as $p)
                                <tr>
                                    <td>{{ $p->first_name }} {{ $p->last_name }}</td>
                                    <td><a class="link" href="mailto:{{ $p->email }}">{{ $p->email }}</a></td>
                                    <td>{{ $p->phone ?? '—' }}</td>
                                    <td>{{ $p->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>


            <!-- Actions -->
            <div class="panel">
                <h2 style="margin-top:0">Quick Actions</h2>

                <button onclick="location.href='{{ route('patients.index') }}'"
                    style="width:100%; margin-bottom:1rem; padding:.75rem; background:var(--primary); color:#fff; border:none; border-radius:6px; cursor:pointer;">
                    View All Patients
                </button>

                <button onclick="location.href='{{ route('signup.form') }}'"
                    style="width:100%; padding:.75rem; background:var(--accent); color:#fff; border:none; border-radius:6px; cursor:pointer;">
                    Add New User
                </button>

        </div>
    </div>

@endsection
