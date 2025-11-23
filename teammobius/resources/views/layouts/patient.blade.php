<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Patient Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    /* ---------- Colors & base ---------- */
    :root{
      --su-blue: #002147; /* primary */
      --su-gold: #C5A100; /* accent */
      --muted: #6c757d;
    }
    html,body{height:100%}
    body {
      font-family: "Segoe UI", Roboto, system-ui, -apple-system, "Helvetica Neue", Arial;
      background: #f5f7fb;
      margin: 0;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

    /* ---------- layout ---------- */
    .app-shell { display:flex; min-height:100vh; transition:all .25s ease; }
    .sidebar {
      width: 250px;
      background: var(--su-blue);
      color: #fff;
      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
      overflow-y: auto;
      padding: 1.25rem 0.75rem;
      transform: translateX(0);
      transition: transform .28s cubic-bezier(.2,.9,.3,1);
      z-index: 1030;
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    /* collapsed state (mobile) */
    .sidebar.collapsed { transform: translateX(-110%); }

    .sidebar .brand {
      display:flex; align-items:center; gap:.6rem; padding:0 .5rem; margin-bottom:1rem;
    }
    .brand .logo {
      width:44px; height:44px; background:#fff; border-radius:8px; display:flex; align-items:center; justify-content:center;
      color:var(--su-blue); font-weight:700; font-size:1.05rem;
    }
    .brand h4{ margin:0; font-size:1.05rem; font-weight:700; color:#fff }

    .nav-link {
      color: #e6eefc;
      padding: 10px .75rem;
      border-radius:8px;
      display:flex; align-items:center; gap:.6rem;
      transition: background .18s ease, transform .12s ease;
    }
    .nav-link:hover, .nav-link:focus { background: rgba(255,255,255,0.06); transform: translateX(4px); color:#fff; text-decoration:none; }
    .nav-link .bi { font-size:1.05rem; }

    .nav-link.active { background: rgba(255,255,255,0.09); box-shadow: inset 0 0 0 1px rgba(255,255,255,0.02); }

    /* user area */
    .sidebar .user {
      display:flex; gap:.6rem; align-items:center; margin: .75rem .5rem 1.2rem;
    }
    .avatar {
      width:44px; height:44px; border-radius:10px; background:#fff; color:var(--su-blue); display:flex; align-items:center; justify-content:center; font-weight:700;
      overflow:hidden;
    }
    .user .meta { color:#f8fbff; font-size:.95rem; }

    /* main content area */
    .content {
      margin-left:250px;
      padding:28px;
      width:100%;
      transition: margin-left .28s cubic-bezier(.2,.9,.3,1);
    }

    /* when sidebar collapsed */
    .sidebar.collapsed + .content { margin-left: 16px; }

    /* responsive: small screens */
    @media (max-width: 768px) {
      .sidebar { position: fixed; }
      .content { margin-left: 0; padding:16px; }
    }

    /* ---------- cards & components ---------- */
    .card { border-radius:12px; transition: transform .18s ease, box-shadow .18s ease; }
    .card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(20,30,60,0.08); }
    .card .card-header { border-top-left-radius:12px; border-top-right-radius:12px; font-weight:700; }

    .badge-status { padding:.45rem .6rem; border-radius: 999px; font-weight:600; }

    /* floating action button */
    .fab {
      position: fixed;
      right: 22px;
      bottom: 28px;
      z-index: 1060;
      width:56px; height:56px; border-radius:50%;
      display:flex; align-items:center; justify-content:center;
      background: var(--su-gold); color: var(--su-blue); font-size:1.35rem; box-shadow: 0 8px 20px rgba(0,0,0,0.12);
      transition: transform .12s ease;
      cursor:pointer; border:none;
    }
    .fab:hover{ transform: translateY(-4px); }

    /* toast container */
    .toast-container-custom { position: fixed; top: 20px; right: 20px; z-index: 1070; }

    /* subtle animations */
    .fade-in { animation: fadeIn .36s ease both; }
    @keyframes fadeIn { from { opacity:0; transform: translateY(6px); } to { opacity:1; transform: none; } }

    /* accessible focus */
    a:focus, button:focus, input:focus { outline: 3px solid rgba(197,161,0,0.18); outline-offset: 2px; border-radius:8px; }

  </style>
</head>
<body>
  <div class="app-shell">

    <!-- SIDEBAR -->
    <aside id="appSidebar" class="sidebar" aria-label="Sidebar navigation">
      <div class="brand">
        <div class="logo">SU</div>
        <h4>Medical Portal</h4>
      </div>

      <!-- user area -->
      <div class="user px-2">
        <!-- Profile picture (if available via backend) else initials -->
        <div class="avatar" id="sidebarAvatar" aria-hidden="true">A</div>
        <div class="meta">
          <div id="sidebarName">Patient</div>
          <small class="text-muted">patient@example.com</small>
        </div>
      </div>

      <nav class="nav flex-column px-2" role="navigation">
        <a class="nav-link active" href="/patient/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a class="nav-link" href="/patient/appointments"><i class="bi bi-calendar-check"></i> My Appointments</a>
        <a class="nav-link" href="/patient/doctors"><i class="bi bi-person-video3"></i> Doctors</a>
        <a class="nav-link" href="/patient/notifications"><i class="bi bi-bell"></i> Notifications <span id="notifBadge" class="badge bg-warning text-dark ms-2" style="display:none">0</span></a>
        <a class="nav-link" href="/patient/settings"><i class="bi bi-gear"></i> Settings</a>

        <hr style="border-color: rgba(255,255,255,0.06); margin: 16px 0;">

        <a class="nav-link text-danger mt-2" href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="content" id="mainContent" tabindex="-1">
      <!-- topbar (mobile hamburger + page title) -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
          <button id="hamburgerBtn" class="btn btn-light d-md-none" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
          </button>

          <h1 id="pageTitle" class="h4 mb-0" style="color:var(--su-blue)">Dashboard</h1>
        </div>

        <div class="d-flex gap-2 align-items-center">
          <!-- small notification icon -->
          <button id="notifBtn" class="btn btn-outline-secondary d-flex align-items-center" aria-label="Notifications">
            <i class="bi bi-bell"></i>
          </button>

          <!-- small profile dropdown (optional backend) -->
          <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" id="profileMenuBtn" data-bs-toggle="dropdown" aria-expanded="false">
              <span id="topbarAvatar" class="me-2" style="display:inline-block; width:32px; height:32px; border-radius:8px; background:#fff; color:var(--su-blue;); text-align:center; line-height:32px; font-weight:700;">A</span>
              <span class="d-none d-md-inline">Patient</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenuBtn">
              <li><a class="dropdown-item" href="/patient/settings">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="/logout">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>

      {{-- page content will be injected here --}}
      <div id="pageContent">
        @yield('content')
      </div>
    </main>
  </div>

  <!-- Floating Action Button -->
  <button id="fabBtn" class="fab" aria-label="Quick book appointment" title="Book appointment">
    <i class="bi bi-plus-lg"></i>
  </button>

  <!-- Toast container -->
  <div class="toast-container-custom" id="toastContainer" aria-live="polite" aria-atomic="true"></div>

  <!-- Bootstrap JS + Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // ---------- Utility: show toast ----------
    function showToast(title = 'Notice', message = '', type = 'info', delay = 3500) {
      const container = document.getElementById('toastContainer');

      const toastEl = document.createElement('div');
      toastEl.className = 'toast align-items-center fade show';
      toastEl.setAttribute('role', 'alert');
      toastEl.setAttribute('aria-live', 'assertive');
      toastEl.setAttribute('aria-atomic', 'true');
      toastEl.style.minWidth = '280px';

      // header with small color
      const header = document.createElement('div');
      header.className = 'd-flex';
      header.style.padding = '0.6rem 0.75rem';
      header.style.borderBottom = '1px solid rgba(0,0,0,0.05)';
      header.innerHTML = '<strong class="me-auto">' + title + '</strong>';
      toastEl.appendChild(header);

      const body = document.createElement('div');
      body.className = 'toast-body';
      body.style.padding = '0.75rem';
      body.innerText = message || '';
      toastEl.appendChild(body);

      container.appendChild(toastEl);

      setTimeout(() => {
        toastEl.classList.remove('show');
        toastEl.classList.add('hide');
        setTimeout(() => toastEl.remove(), 300);
      }, delay);
    }

    // ---------- Sidebar toggle for mobile ----------
    (function() {
      const sidebar = document.getElementById('appSidebar');
      const hamburgerBtn = document.getElementById('hamburgerBtn');
      const fab = document.getElementById('fabBtn');

      hamburgerBtn.addEventListener('click', function() {
        const collapsed = sidebar.classList.toggle('collapsed');
        // aria-expanded
        hamburgerBtn.setAttribute('aria-expanded', String(!collapsed));
      });

      // hide sidebar on small screens when clicking outside
      document.addEventListener('click', (e) => {
        const target = e.target;
        if (window.innerWidth <= 768) {
          if (!sidebar.contains(target) && !hamb
