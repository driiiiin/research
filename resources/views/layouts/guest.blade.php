<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Herdin') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap 5.3 and icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                margin: 0;
                padding: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .header-fixed {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1050;
                background: white;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .main-content {
                flex: 1;
                display: flex;
                flex-direction: column;
                /* margin-top: 120px; */
                min-height: calc(100vh - 120px - 80px);
            }

            .content-wrapper {
                flex: 1;
                padding: 20px;
            }

            .footer {
                margin-top: auto;
                background: #FAF9F6;
                height: 80px;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <!-- Fixed Header -->
        <div class="header-fixed">
            @include('partials.header')
        </div>

        <!-- Main Content Area -->
        <div class="main-content" style="padding-top: 70px;">
            <div class="content-wrapper">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="footer">
                @include('partials.footer')
            </div>
        </div>
    </body>
</html>
