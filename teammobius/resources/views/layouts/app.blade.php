<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Mobius')</title>

    <style>
        :root {
            --primary: #02338D;
            --accent: #E41E26;
            --bg: #f6f8fb;
            --muted: #6b7280;
            --sidebar-width: 260px;
            --sidebar-collapsed: 72px;
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%
        }

        body {
            margin: 0;
            font-family: Poppins, sans-serif;
            background: var(--bg);
            color: #111;
            -webkit-font-smoothing: antialiased;
        }

        /* shell */
        .shell {
            min-height: 100vh;
            display: flex;
            align-items: stretch;
        }

        /* Sidebar CSS (kept here so it affects the entire app) */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: #fff;
            border-right: 1px solid #eef2f6;
            padding: 1.25rem;
            overflow-y: auto;
            box-shadow: 0 2px 8px rgba(2, 12, 45, 0.03);
            z-index: 1000;
            transition: width 200ms ease, left 300ms ease;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.25rem
        }

        .brand img {
            height: 48px;
            border-radius: 6px
        }

        .brand h2 {
            margin: 0;
            color: var(--primary);
            font-size: 1.05rem
        }

        .brand .muted {
            font-size: 0.85rem;
            color: var(--muted)
        }

        .nav {
            margin-top: 0.5rem
        }

        .nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: .7rem .8rem;
            border-radius: 8px;
            color: #0b1a2b;
            text-decoration: none;
            margin-bottom: .35rem;
            transition: background 120ms ease, transform 120ms ease;
        }

        .nav a .icon {
            width: 18px;
            height: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            opacity: 0.9
        }

        .nav a .label {
            display: inline-block
        }

        .nav a:hover {
            background: #f6f9fc;
            transform: translateY(-1px)
        }

        .nav a.active {
            background: linear-gradient(90deg, #f4f7fb, #fff);
            box-shadow: 0 6px 18px rgba(2, 12, 45, 0.03);
            color: var(--primary);
            font-weight: 600;
            border-left: 4px solid var(--primary);
            padding-left: calc(.8rem - 4px);
        }

        body.sidebar-collapsed .sidebar {
            width: var(--sidebar-collapsed);
        }

        body.sidebar-collapsed .nav a .label {
            display: none;
        }

        body.sidebar-collapsed .brand h2,
        body.sidebar-collapsed .brand .muted {
            display: none;
        }

        body.sidebar-collapsed .nav a.active {
            padding-left: .8rem;
            border-left: none;
        }

        .sidebar::-webkit-scrollbar {
            width: 10px
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(2, 12, 45, 0.06);
            border-radius: 6px
        }

        /* content */
        .content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 1.5rem 2rem;
            min-height: 100vh;
            transition: margin-left 200ms ease, padding 200ms ease;
        }

        body.sidebar-collapsed .content {
            margin-left: var(--sidebar-collapsed);
        }

        /* Option B: dashboard center/wider look */
        body.route-dashboard .content {
            padding: 2.5rem 3rem;
            background: transparent;
        }

        body.route-dashboard .content>.container {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* dashboard card/panel */
        .card-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.25rem
        }

        .card {
            background: #fff;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.04)
        }

        .panel {
            background: #fff;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.04)
        }

        /* top controls */
        .top-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
            justify-content: flex-end
        }

        .logout-btn {
            background: var(--accent);
            color: #fff;
            padding: .5rem .85rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        /* mobile drawer behavior */
        @media (max-width:900px) {
            .sidebar {
                left: -260px;
                width: var(--sidebar-width);
                transition: left 300ms ease;
            }

            body.sidebar-open .sidebar {
                left: 0;
            }

            /* overlay shown only while mobile open (we add a div .mobile-overlay in the body) */
            .mobile-overlay {
                display: none;
            }

            body.sidebar-open .mobile-overlay {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.35);
                z-index: 900;
            }

            .content {
                margin-left: 0 !important;
                padding: 1rem;
            }

            body.route-dashboard .content {
                padding: 1rem;
            }
        }
    </style>
</head>

<body class="{{ request()->routeIs('dashboard') ? 'route-dashboard' : '' }}">
    <div class="shell">
        {{-- sidebar partial (keeps layout clean) --}}
        @include('partials.sidebar')

        {{-- main content area --}}
        <main class="content" role="main">
            {{-- header/top controls (toggle + optional slots) --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem">
                <div style="display:flex;align-items:center;gap:12px">
                    <button id="sidebarToggle" aria-label="Toggle sidebar"
                        style="background:#fff;border:1px solid #e6edf3;padding:.45rem .65rem;border-radius:8px;cursor:pointer">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path d="M3 12h18M3 6h18M3 18h18" stroke="#333" stroke-width="1.6"
                                stroke-linecap="round" />
                        </svg>
                    </button>

                    @yield('top-left')
                </div>

                <div class="top-controls">
                    @yield('top-right')
                </div>
            </div>

            {{-- page content --}}
            @yield('content')
        </main>
    </div>

    {{-- mobile overlay for drawer (clicking it closes the drawer) --}}
    <div class="mobile-overlay" aria-hidden="true"></div>

    {{-- JS: toggle behavior (desktop collapse + mobile drawer) --}}
    <script>
        (function() {
            const btn = document.getElementById('sidebarToggle');
            const overlay = document.querySelector('.mobile-overlay');
            if (!btn) return;

            // restore desktop collapsed state
            if (localStorage.getItem('mobius.sidebarCollapsed') === '1') {
                document.body.classList.add('sidebar-collapsed');
            }

            btn.addEventListener('click', () => {
                if (window.innerWidth <= 900) {
                    document.body.classList.toggle('sidebar-open');
                } else {
                    document.body.classList.toggle('sidebar-collapsed');
                    const collapsed = document.body.classList.contains('sidebar-collapsed') ? '1' : '0';
                    localStorage.setItem('mobius.sidebarCollapsed', collapsed);
                }
            });

            // clicking overlay closes mobile sidebar
            overlay.addEventListener('click', () => {
                document.body.classList.remove('sidebar-open');
            });

            // close mobile sidebar when resizing to desktop
            window.addEventListener('resize', () => {
                if (window.innerWidth > 900) {
                    document.body.classList.remove('sidebar-open');
                }
            });
        })();
    </script>
</body>

</html>
