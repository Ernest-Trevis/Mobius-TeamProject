{{-- resources/views/partials/sidebar.blade.php --}}
<aside class="sidebar" role="navigation" aria-label="Main navigation">
    <div class="brand" aria-hidden="false">
        {{-- change to asset('images/logo.png') when you put the logo in public/images --}}
        <img src="img/Logo.png" alt="Mobius logo">
        <div>
            <h2>Mobius</h2>
            <div class="muted">Medical</div>
        </div>
    </div>

    <nav class="nav" aria-label="Sidebar links">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="icon" aria-hidden="true"><!-- home svg --><svg width="18" height="18"
                    viewBox="0 0 24 24" fill="none">
                    <path d="M3 10L12 3l9 7" stroke="#02338D" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M9 21V12h6v9" stroke="#02338D" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg></span>
            <span class="label">Dashboard</span>
        </a>

        <a href="{{ route('patients.index') }}" class="{{ request()->routeIs('patients.*') ? 'active' : '' }}">
            <span class="icon" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24"
                    fill="none">
                    <path d="M17 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2" stroke="#02338D" stroke-width="1.6"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <circle cx="12" cy="7" r="4" stroke="#02338D" stroke-width="1.6"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>
            <span class="label">Patients</span>
        </a>

        <a href="{{ route('signup.form') }}">
            <span class="icon" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24"
                    fill="none">
                    <path d="M12 5v14M5 12h14" stroke="#02338D" stroke-width="1.6" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg></span>
            <span class="label">Add User</span>
        </a>

        <a href="#" onclick="alert('Counselling coming soon')" role="button">
            <span class="icon" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24"
                    fill="none">
                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" stroke="#02338D"
                        stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>
            <span class="label">Counselling</span>
        </a>

        <a href="#" onclick="alert('Reports coming soon')" role="button">
            <span class="icon" aria-hidden="true"><svg width="18" height="18" viewBox="0 0 24 24"
                    fill="none">
                    <path d="M3 7h18M3 12h18M3 17h12" stroke="#02338D" stroke-width="1.4" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg></span>
            <span class="label">Reports</span>
        </a>
    </nav>
</aside>
