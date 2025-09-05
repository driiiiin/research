<x-guest-layout>
    <!-- Session Status -->
    @if(session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session("status") }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#6366f1'
                });
            });
        </script>
    @endif

    <!-- Dark green background header with logo and title -->
    <!-- <div class="w-100 d-flex flex-column align-items-center justify-content-center" style="height: 120px; border-radius: 0.5rem; background-color: #14532d;">
        <div class="d-flex w-100 align-items-center justify-content-between" style="height: 64px;"> -->
            <!-- Left: DOH Logo -->
            <!-- <img src="{{ asset('images/DOH-logo.png') }}" alt="DOH Logo" style="height: 64px; margin-left: 1rem;" class="mb-2" onerror="this.style.display='none'"> -->

            <!-- Centered Title and Subtitle -->
            <!-- <div class="d-flex flex-column align-items-center w-100">
                <div class="text-white-50 mt-1 text-center" style="font-size: 1rem;">Department of Health</div>
                <h5 class="text-white fw-bold mb-0 text-center" style="letter-spacing: 2px; font-size: .8rem;">{{ str_replace('_', ' ', config('app.name', 'Health Research Repository')) }}</h5>
            </div> -->

            <!-- Right: BP Logo -->
            <!-- <img src="{{ asset('images/BP-logo.png') }}" alt="BP Logo" style="height: 75px; margin-right: 1rem;" class="mb-2" onerror="this.style.display='none'">
        </div>
    </div> -->

    <!-- Login form section -->
    <div class="p-4 mx-auto shadow-lg rounded w-full" style="max-width: 420px; background-color: white;">
        <div class="mb-4 text-center">
            <h2 class="fw-semibold" style="font-size: 1.5rem;">Welcome</h2>
            <p class="text-muted" style="font-size: 1rem;">Please login to continue</p>
        </div>
        <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf

            <!-- Username or Email Address -->
            <div>
                <x-input-label for="login" :value="__('Username or Email Address')" class="bi bi-person-fill" />
                <x-text-input id="login" class="block mt-1 w-full"
                    type="text"
                    name="login"
                    required autofocus
                    placeholder="Enter Username or Email Address" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="bi bi-lock-fill" />

                <div style="position: relative;">
                    <x-text-input id="password" class="block mt-1 w-full pe-5"
                        type="password"
                        name="password"
                        required autocomplete="current-password"
                        style="padding-right: 2.5rem;"
                    />
                    <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); cursor: pointer; z-index: 2;">
                        <i class="bi bi-eye-fill" id="eye" onclick="showPassword()"></i>
                    </span>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <x-input-error :messages="$errors->get('login')" class="mt-2" />
            </div>

            <!-- Forgot Password Link -->
            <div class="flex items-center justify-end mt-2">
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 hover:text-gray-900 transition-colors duration-200" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <script>
                function showPassword() {
                    var x = document.getElementById("password");
                    var eye = document.getElementById("eye");
                    if (x.type === "password") {
                        x.type = "text";
                        eye.classList.remove("bi-eye-fill");
                        eye.classList.add("bi-eye-slash-fill");
                    } else {
                        x.type = "password";
                        eye.classList.remove("bi-eye-slash-fill");
                        eye.classList.add("bi-eye-fill");
                    }
                }
            </script>

            <!-- Remember Me (optional, uncomment if needed) -->
            <!--
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            -->

            <!-- Terms and Conditions Agreement -->
            <!-- <div class="flex items-start mt-4">
                <label for="terms_agree" class="mt-1">
                    <input id="terms_agree" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="terms_agree" required>
                    <span class="sr-only">I agree</span>
                </label>
                <div class="ms-2 text-sm text-gray-600 text-justify w-full" style="text-align: justify;">
                    I have read about the <a href="#" class="underline text-blue-600 hover:text-blue-800">Terms and Conditions</a> and express my consent thereto.
                </div>
            </div>
            <span id="terms-error" class="text-red-600 text-sm hidden">You must agree to the terms and conditions.</span> -->

            <!-- Captcha Section -->
            <div class="mt-4">
                <!-- Hidden field for captcha ID -->
                <input type="hidden" id="captcha_id" name="captcha_id" value="{{ old('captcha_id', $captcha_id ?? session('captcha_id')) }}">

                <div class="flex items-center gap-2">
                    <span id="captchaSvgContainer" style="display: flex; align-items: center; flex: 1 1 0; min-width: 0;">
                        {!! str_replace('<svg ', '<svg style="width:100%;height:44px;max-width:100%;" ', old('captcha_svg', $captcha_svg ?? session('captcha_svg_' . ($captcha_id ?? session('captcha_id'))))) !!}
                    </span>
                    <button type="button" id="refreshCaptchaBtn" title="Refresh Captcha" class="inline-flex items-center justify-center rounded-full focus:outline-none bg-white hover:bg-gray-100 transition-colors duration-200 shadow-sm" style="height: 44px; width: 44px; color: #14532d; border: 1px solid #e5e7eb;">
                        <i class="fa fa-sync-alt" aria-hidden="true" style="color: #14532d; font-size: 14px;"></i>
                    </button>
                </div>
                <input id="captcha_input" name="captcha_input" type="text" maxlength="6" autocomplete="off" required placeholder="Enter Captcha" class="mt-2 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('captcha_input')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- End Captcha Section -->

            <div class="flex flex-col items-center justify-center mt-4">
                <button type="submit" class="btn w-full flex justify-center" style="background-color: #14532d; color: #fff;">
                    {{ __('Log in') }}
                </button>

                <!-- @if (Route::has('register'))
                    <div class="mt-4 text-center text-sm text-gray-600">
                        {{ __("Don't have an account?") }}
                        <a class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors duration-200 ms-1" href="{{ route('register') }}">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endif -->
            </div>
        </form>
    </div>
    <script>
        window.history.forward();

        function noBack() {
            window.history.forward();
        }

        // Captcha refresh functionality
        document.addEventListener('DOMContentLoaded', function() {
            const refreshBtn = document.getElementById('refreshCaptchaBtn');
            const captchaContainer = document.getElementById('captchaSvgContainer');
            const captchaIdInput = document.getElementById('captcha_id');
            const captchaInput = document.getElementById('captcha_input');

            if (refreshBtn) {
                refreshBtn.addEventListener('click', function() {
                    // Disable button and show loading state
                    refreshBtn.disabled = true;
                    const icon = refreshBtn.querySelector('i');
                    icon.classList.add('animate-spin');

                    // Clear captcha input
                    captchaInput.value = '';

                    // Make AJAX request to refresh captcha
                    fetch('{{ route("captcha.refresh") }}', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update captcha SVG
                            const newSvg = data.captcha_svg.replace('<svg ', '<svg style="width:100%;height:44px;max-width:100%;" ');
                            captchaContainer.innerHTML = newSvg;

                            // Update captcha ID
                            captchaIdInput.value = data.captcha_id;

                            // Focus on captcha input
                            captchaInput.focus();
                        } else {
                            console.error('Failed to refresh captcha');
                            // Show error message to user instead of reloading
                            alert('Failed to refresh captcha. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error refreshing captcha:', error);
                        // Show error message to user instead of reloading
                        alert('Error refreshing captcha. Please try again.');
                    })
                    .finally(() => {
                        // Re-enable button and remove loading state
                        refreshBtn.disabled = false;
                        icon.classList.remove('animate-spin');
                    });
                });
            }
        });

    </script>
</x-guest-layout>
