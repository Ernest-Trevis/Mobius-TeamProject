<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title')</title>
    <style>
        :root {
            --primary-color: #02338D;
            --secondary-color: #E41E26;
            --bg: #EAF0FA;
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font-family: Poppins, sans-serif;
            background: var(--bg)
        }


        /* Shared container */
        .auth-container {
            position: relative;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--primary-color);
            overflow-y: auto;
            padding: 2rem 0
        }

        .overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #02338D 60%, #012866);
            opacity: 0.95;
            z-index: 1
        }


        /* Shared card */
        .auth-card {
            position: relative;
            z-index: 2;
            background: #fff;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 520px;
            text-align: center;
            margin: 1rem
        }


        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
            margin-bottom: 0.75rem
        }

        .brand img {
            height: 44px;
            border-radius: 6px
        }

        h2 {
            color: var(--primary-color);
            margin: 0.25rem 0 1rem;
            font-weight: 600
        }


        /* Form */
        form {
            display: flex;
            flex-direction: column;
            gap: 0.9rem
        }

        .form-row {
            display: flex;
            gap: 1rem
        }

        /* Remember checkbox + label alignment */
        .remember {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            /* space between checkbox and text */
            justify-content: flex-start;
            margin: 0.25rem 0 0.9rem;
            /* adjust spacing above/below */
            font-size: 0.95rem;
            color: #111;
        }

        /* Slightly larger clickable checkbox for touch devices */
        .remember input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin: 0;
            /* remove default margin */
            accent-color: #02338D;
            /* modern browsers show the primary color */
        }

        /* On very small screens keep everything full width and readable */
        @media (max-width:480px) {
            .remember {
                gap: 0.45rem;
                font-size: 0.92rem;
            }

            .remember input[type="checkbox"] {
                width: 16px;
                height: 16px;
            }
        }


        input,
        select {
            padding: 0.85rem;
            border-radius: 0.5rem;
            border: 1px solid #ccc;
            font-size: 1rem;
            width: 100%
        }

        button {
            background: var(--secondary-color);
            color: #fff;
            padding: 0.9rem;
            border: none;
            border-radius: 0.6rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%
        }

        button:hover {
            filter: brightness(0.95)
        }


        /* Links */
        .text-small {
            margin-top: 1rem;
            font-size: 0.95rem;
            color: #444
        }

        a.link {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none
        }


        /* Errors */
        .errors {
            background: #fee;
            border: 1px solid #f5c2c2;
            padding: 0.8rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            color: #7a1a1a;
            text-align: left
        }


        /* Responsive */
        @media (max-width:768px) {
            .form-row {
                flex-direction: column
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="overlay"></div>


        <div class="auth-card">



            @yield('content')


        </div>
    </div>
</body>

</html>
