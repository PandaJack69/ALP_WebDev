<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            display: flex;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        #background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .nav {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            display: flex;
            gap: 1rem;
        }

        .nav a {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            color: white;
            background-color: #FF2D20;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .nav a:hover {
            background-color: #e0261c;
        }

        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
            width: 40%;
            min-width: 300px;
            background: rgba(0, 0, 0, 0.7); 
            color: #f8f9fa; /* Light text color for contrast */
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .content h1 {
            font-size: 2.5rem;
            color: #FF2D20; /* Highlighted text color */
            margin-bottom: 1rem;
        }

        .content p {
            font-size: 1rem;
            color: #f1f1f1; /* Softer light color for paragraph text */
            margin-bottom: 1.5rem;
        }

        .content a {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            color: white;
            background-color: #FF2D20;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .content a:hover {
            background-color: #e0261c;
        }

        @media (max-width: 768px) {
            .content {
                width: 80%;
                padding: 1.5rem;
            }

            .content h1 {
                font-size: 2rem;
            }

            .content p {
                font-size: 0.9rem;
            }

            .content a {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }
        }
    </style>
</head>
<body>
    <img id="background" src="{{ asset('images/catering_bg.jpg') }}" alt="Background Image" />

    <!-- Navigation -->
    <div class="nav">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        @endif
    </div>

    <!-- Main Content -->
    <div class="content">
        <img src="{{ asset('images/logo_alpWD.png') }}" alt="Logo Image" class="logo"/>
        <h1>Welcome to Our Catering Service</h1>
        <p>
            World-class catering solutions made for the sole purpose of benefiting you. Events, parties, gatherings, or day-to-day caterings , we've got you covered.
        </p>
        <a href="{{ route('register') }}">Explore Our Services</a>
    </div>

    <style>
        .content img.logo {
            max-width: 100%; /* Ensures the logo doesn't exceed the container's width */
            height: auto; /* Maintains the aspect ratio */
            width: 150px; /* Adjust this value to control the default size */
            margin: 0 auto 1.5rem; /* Centers the logo and adds spacing below */
            display: block; /* Ensures the logo behaves as a block-level element for centering */
        }
    </style>
</body>
</html>
