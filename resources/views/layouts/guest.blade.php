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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5.3 and icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 120px - 80px);
        }

        .content-wrapper {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen flex flex-col items-center justify-center">
    <!-- Fixed Header -->
    <div class="header-fixed w-full">
        @include('partials.header')
    </div>

    <!-- Main Content Area -->
    <div class="main-content w-full flex-1 flex flex-col" style="padding-top: 70px;">
        <div class="content-wrapper w-full">
            {{ $slot }}
        </div>

        <!-- Back to Top Button -->
        <button id="backToTopBtn" title="Back to Top"
            style="display: none; position: fixed; bottom: 80px; right: 32px; z-index: 9999; border: none; border-radius: 50%; width: 44px; height: 44px; cursor: pointer; transition: opacity 0.3s; align-items: center; justify-content: center; background: #000; color: #fff;">
            <i class="bi bi-arrow-up"
                style="font-size: 1.3rem; display: flex; align-items: center; justify-content: center; height: 100%; width: 100%; line-height: 1;"></i>
        </button>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var btn = document.getElementById('backToTopBtn');
                // Show/hide back to top button on scroll
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 50) {
                        btn.style.display = 'block';
                    } else {
                        btn.style.display = 'none';
                    }
                });

                // Scroll to top when button is clicked
                btn.addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            });
        </script>

        <!-- Footer -->
        <div class="footer w-full">
            @include('partials.footer')
        </div>
    </div>

</html>
