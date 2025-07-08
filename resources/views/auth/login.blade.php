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
    <div class="p-4 m-4 mx-auto" style="max-width: 500px;">
        <div class="mb-4 text-center">
            <h2 class="fw-semibold" style="font-size: 1.5rem;">Welcome</h2>
            <p class="text-muted" style="font-size: 1rem;">Please login to continue</p>
        </div>
        <form method="POST" action="{{ route('login') }}">
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

            <div class="flex flex-col items-center justify-center mt-4">
                <button type="submit" class="btn w-full flex justify-center" style="background-color: #14532d; color: #fff;">
                    {{ __('Log in') }}
                </button>

                @if (Route::has('register'))
                    <div class="mt-4 text-center text-sm text-gray-600">
                        {{ __("Don't have an account?") }}
                        <a class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors duration-200 ms-1" href="{{ route('register') }}">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endif
            </div>
        </form>
    </div>
    <script>
        window.history.forward();
        function noBack() {
            window.history.forward();
        }
    </script>
    <body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
</x-guest-layout>
