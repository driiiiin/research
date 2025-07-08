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
                <x-text-input id="password" class="block mt-1 w-full pe-5" {{-- use pe-5 for Bootstrap padding-end --}}
                    type="password"
                    name="password"
                    required autocomplete="current-password"
                    style="padding-right: 2.5rem;" {{-- fallback for custom padding if needed --}}
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

        <!-- Remember Me -->
        <!-- <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div> -->

        <div class="flex flex-col items-center justify-center mt-4">
            <x-primary-button class="w-full flex justify-center">
                {{ __('Log in') }}
            </x-primary-button>

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
</x-guest-layout>
