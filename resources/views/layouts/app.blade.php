<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'health_research') }}</title>

        <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Scripts -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen flex flex-col" data-swal-success="{{ e(session('success') ?? '') }}"
    data-swal-error="{{ e(session('error') ?? '') }}">
    <!-- SVG ICON SPRITE FOR GLOBAL USE -->
    <svg style="display: none;">
        <symbol id="icon-document-text" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"/>
        </symbol>
        <symbol id="icon-beaker" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="10" stroke-width="2"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6"/>
        </symbol>
        <symbol id="icon-user" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/>
        </symbol>
        <symbol id="icon-book-open" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20l9-5-9-5-9 5 9 5z"/>
        </symbol>
        <symbol id="icon-collection" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <rect x="3" y="7" width="18" height="10" rx="2" stroke-width="2"/>
        </symbol>
        <symbol id="icon-location-marker" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s8-4.5 8-10A8 8 0 0 0 4 12c0 5.5 8 10 8 10z"/>
        </symbol>
        <symbol id="icon-academic-cap" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a9 9 0 0 1 14 0"/>
        </symbol>
    </svg>

    <!-- Fixed Header -->
    <div class="fixed-header w-full z-50">
        @include('partials.header')
    </div>

    <!-- Navigation below header -->
    <div class="w-full bg-white border-b border-gray-200 mt-20 lg:mt-20">
        @include('layouts.navigation')
    </div>

    <!-- Main Content Area -->
    <div class="main-content flex-1 w-full container-fluid">
        <div class="content-wrapper max-w-7xl mx-auto">
            {{ $slot }}
        </div>
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
    <div class="footer">
        @include('partials.footer')
    </div>
    <script>
        let timeout;

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(logoutUser, 3600000); // 1 hour (3,600,000 ms)
            // timeout = setTimeout(logoutUser , 60000);// 1 minute
            // timeout = setTimeout(logoutUser , 30000);// 30 sec
        }

        function logoutUser() {
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle custom SweetAlert data from session
            var swalData = @json(session('swal'));
            if (swalData) {
                Swal.fire({
                    title: swalData.title,
                    text: swalData.text,
                    icon: swalData.icon,
                    confirmButtonText: swalData.button,
                    confirmButtonColor: '#6C63FF',
                });
            }

            // Handle success messages
            var successMsg = document.body.getAttribute('data-swal-success');
            if (successMsg) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: successMsg,
                    confirmButtonColor: '#6C63FF',
                });
            }

            // Handle error messages
            var errorMsg = document.body.getAttribute('data-swal-error');
            if (errorMsg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg,
                    confirmButtonColor: '#6C63FF',
                });
            }
        });
    </script>
</body>
</html>
