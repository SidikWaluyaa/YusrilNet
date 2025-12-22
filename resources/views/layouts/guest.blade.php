<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>YusrilNet</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=montserrat:300,400,500,600,700&display=swap" rel="stylesheet" />

    <link rel="shortcut icon" href="{{ asset('Logo.png') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --neptune-blue: #1a73e8;
            --neptune-dark: #0d47a1;
            --neptune-light: #4fc3f7;
            --neptune-accent: #00b0ff;
            --neptune-gradient-start: #1a73e8;
            --neptune-gradient-end: #0288d1;
            --neptune-pale: #e3f2fd;
        }

        body {
            font-family: 'Montserrat', 'Figtree', sans-serif;
            background: linear-gradient(135deg, var(--neptune-gradient-start), var(--neptune-gradient-end));
            background-attachment: fixed;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated wave background */
        .wave-container {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 0;
        }

        .wave {
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            border-radius: 43%;
            background: rgba(255, 255, 255, 0.1);
            animation: wave 20s linear infinite;
        }

        .wave:nth-child(2) {
            border-radius: 47%;
            background: rgba(255, 255, 255, 0.07);
            animation: wave 15s linear infinite;
        }

        .wave:nth-child(3) {
            border-radius: 40%;
            background: rgba(255, 255, 255, 0.05);
            animation: wave 25s linear infinite;
        }

        @keyframes wave {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Floating bubbles */
        .bubbles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            top: 0;
            left: 0;
        }

        .bubble {
            position: absolute;
            bottom: -100px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            opacity: 0.5;
            animation: rise 10s infinite ease-in;
        }

        .bubble:nth-child(1) {
            width: 40px;
            height: 40px;
            left: 10%;
            animation-duration: 8s;
        }

        .bubble:nth-child(2) {
            width: 20px;
            height: 20px;
            left: 20%;
            animation-duration: 5s;
            animation-delay: 1s;
        }

        .bubble:nth-child(3) {
            width: 50px;
            height: 50px;
            left: 35%;
            animation-duration: 7s;
            animation-delay: 2s;
        }

        .bubble:nth-child(4) {
            width: 80px;
            height: 80px;
            left: 50%;
            animation-duration: 11s;
            animation-delay: 0s;
        }

        .bubble:nth-child(5) {
            width: 35px;
            height: 35px;
            left: 55%;
            animation-duration: 6s;
            animation-delay: 1s;
        }

        .bubble:nth-child(6) {
            width: 45px;
            height: 45px;
            left: 65%;
            animation-duration: 8s;
            animation-delay: 3s;
        }

        .bubble:nth-child(7) {
            width: 90px;
            height: 90px;
            left: 70%;
            animation-duration: 12s;
            animation-delay: 2s;
        }

        .bubble:nth-child(8) {
            width: 25px;
            height: 25px;
            left: 80%;
            animation-duration: 6s;
            animation-delay: 2s;
        }

        @keyframes rise {
            0% {
                bottom: -100px;
                transform: translateX(0);
            }

            50% {
                transform: translateX(100px);
            }

            100% {
                bottom: 1080px;
                transform: translateX(-200px);
            }
        }

        /* Card container */
        .neptune-card {
            background: rgba(255, 255, 255, 0.95) !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.18) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease !important;
            z-index: 10;
            position: relative;
        }

        .neptune-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2) !important;
        }

        /* Logo container */
        .logo-container {
            background: white;
            border-radius: 50%;
            padding: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            z-index: 10;
            position: relative;
            transition: transform 0.3s ease;
        }

        .logo-container:hover {
            transform: scale(1.05);
        }

        /* Button styles */
        .btn-neptune {
            background: linear-gradient(to right, var(--neptune-blue), var(--neptune-accent));
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(26, 115, 232, 0.3);
        }

        .btn-neptune:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(26, 115, 232, 0.4);
        }

        /* Input fields */
        .neptune-input {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .neptune-input:focus {
            border-color: var(--neptune-blue);
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
            outline: none;
        }

        /* Links */
        .neptune-link {
            color: var(--neptune-blue);
            transition: color 0.3s ease;
            font-weight: 500;
        }

        .neptune-link:hover {
            color: var(--neptune-dark);
            text-decoration: underline;
        }

        /* Main content area */
        .content-wrapper {
            position: relative;
            z-index: 10;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <!-- Wave Animation Background -->
    <div class="wave-container">
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <!-- Floating Bubbles -->
    <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 content-wrapper">
        <div class="w-full flex justify-center mt-6">
            <a href="/">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="mx-auto h-20 w-auto">
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-8 py-6 neptune-card">
            {{ $slot }}
        </div>

        <div class="mt-6 text-center text-white text-sm opacity-80">
            &copy; {{ date('Y') }} YusrilNet. All rights reserved.
        </div>
    </div>

    <script>
        // Apply neptune styles to existing elements
        document.addEventListener('DOMContentLoaded', function() {
            // Style all buttons
            const buttons = document.querySelectorAll('button[type="submit"], .btn, .button');
            buttons.forEach(button => {
                button.classList.add('btn-neptune');
            });

            // Style all inputs
            const inputs = document.querySelectorAll(
                'input[type="text"], input[type="email"], input[type="password"], input[type="number"]');
            inputs.forEach(input => {
                input.classList.add('neptune-input');
            });

            // Style all links
            const links = document.querySelectorAll('a:not(.logo-container a)');
            links.forEach(link => {
                link.classList.add('neptune-link');
            });
        });
    </script>
</body> 

</html>
