<!-- filepath: /home/fitapp/tin.fitapp.cloud/odmaranje/resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>404 | {{ env('APP_NAME', 'Laravel') }}</title>

        <link rel="icon" href="{{ url('/favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.scss', 'resources/js/app.js'])
        @endif

        <style>
            .container {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 100vh;
                text-align: center;
            }
            .container h1 {
                font-size: 3rem;
                margin-bottom: 1rem;
            }
            .container p {
                font-size: 1.5rem;
                margin-bottom: 1.5rem;
            }
            .container a {
                font-size: 1.2rem;
                color: #3490dc;
                text-decoration: none;
                border: 1px solid #3490dc;
                padding: 0.5rem 1rem;
                border-radius: 0.25rem;
                transition: background-color 0.3s, color 0.3s;
            }
            .container a:hover {
                background-color: #3490dc;
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class="min-h-screen bg-gray-100">
            <main>
                <div class="container">
                    <h1>404 - Stranica nije pronađena</h1>
                    <p>Stranica koju tražite ne postoji.</p>
                    <a href="{{ route('guest.home') }}">Vrati se na početnu stranicu</a>
                </div>
            </main>
        </div>       
    </body>
</html>