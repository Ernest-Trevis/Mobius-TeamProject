 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>

    <!-- Bootstrap CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px; 
            height: 100vh;
            background-color: #002147; 
            position: fixed;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            display: block;
            border-radius: 6px;
        }

        .sidebar a:hover {
            background: #003366;
        }

        .sidebar .active {
            background: #003d75 !important;
        }

        /* MAIN CONTENT */
        .content-area {
            margin-left: 250px;
            padding: 25px;
        }

        .card {
            border-radius: 12px;
            }
            
        .card-header {
            font-weight: bold;
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
            }


        /* MOBILE RESPONSIVE */
        @media(max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content-area {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Content --}}
    <div class="content-area">
        @yield('content')
    </div>

</body>
</html>
