<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    <body class="font-sans antialiased">
        <!-- Fixed Header and Navigation -->
        <div class="fixed-header">
            @include('partials.header')
            @include('layouts.navigation')
        </div>

        <!-- Main Content Area -->
        <div class="main-content container-fluid">
            <div class="content-wrapper">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="footer">
                @include('partials.footer')
            </div>
        </div>
    </body>
    <script>
        let timeout;

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(logoutUser , 3600000); // 1 hour (3,600,000 ms)
            // timeout = setTimeout(logoutUser , 60000);// 1 minute
            // timeout = setTimeout(logoutUser , 30000);// 30 sec
        }

        function logoutUser () {
            Swal.fire({
                title: 'Auto Logout',
                text: 'You have been automatically logged out due to inactivity. Please login again to continue.',
                icon: 'warning',
                showCancelButton: false,
                confirmButtonText: 'Login Again',
                allowEnterKey: true, // allow enter key to confirm
                didOpen: () => {
                    // Add keydown listener for Enter key
                    document.addEventListener('keydown', handleEnterKeyForSwal);
                },
                willClose: () => {
                    // Remove keydown listener to avoid memory leaks
                    document.removeEventListener('keydown', handleEnterKeyForSwal);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    performLogout();
                }
            });
        }

        function handleEnterKeyForSwal(e) {
            // Only trigger if the SweetAlert2 modal is open and Enter is pressed
            if (e.key === 'Enter') {
                const swalConfirmBtn = document.querySelector('.swal2-confirm');
                if (swalConfirmBtn) {
                    swalConfirmBtn.click();
                }
            }
        }

        function performLogout() {
            // Create a form and submit it to logout
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('logout') }}';

            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            document.body.appendChild(form);
            form.submit();
        }

        // Reset timer on user activity
        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onkeydown = resetTimer;
        window.onscroll = resetTimer;
        window.onclick = resetTimer;
        window.ontouchmove = resetTimer;

        // Add event listener for beforeunload
        window.addEventListener('beforeunload', function(e) {
            // Optional: Add any cleanup logic here
            // e.preventDefault();
            // e.returnValue = '';
        });
    </script>
</html>
