<x-guest-layout>
    <!-- Session Status -->
    @if(session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Warning!',
                    text: '{{ session("warning") }}',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#f59e0b'
                });
            });
        </script>
    @endif

    <!-- Password Change form section -->
    <div class="pt-4 mt-5 p-4 m-4 mx-auto shadow-lg rounded" style="max-width: 420px;">
        <div class="mb-4 text-center">
            <h2 class="fw-semibold" style="font-size: 1.5rem;">Change Password</h2>
            <p class="text-muted" style="font-size: 1rem;">Please change your password to continue</p>
        </div>

        <form method="POST" action="{{ route('password.change.store') }}" id="password-change-form">
            @csrf

            <!-- Current Password -->
            <div>
                <x-input-label for="current_password" :value="__('Current Password')" class="bi bi-lock-fill" />
                <div style="position: relative;">
                    <x-text-input id="current_password" class="block mt-1 w-full pe-5"
                        type="password"
                        name="current_password"
                        required autofocus
                        placeholder="Enter your current password"
                        style="padding-right: 2.5rem;"
                    />
                    <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); cursor: pointer; z-index: 2;">
                        <i class="bi bi-eye-fill" id="eye-current" onclick="showPassword('current_password', 'eye-current')"></i>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
            </div>

            <!-- New Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('New Password')" class="bi bi-lock-fill" />
                <div style="position: relative;">
                    <x-text-input id="password" class="block mt-1 w-full pe-5"
                        type="password"
                        name="password"
                        required
                        placeholder="Enter your new password"
                        style="padding-right: 2.5rem;"
                    />
                    <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); cursor: pointer; z-index: 2;">
                        <i class="bi bi-eye-fill" id="eye-new" onclick="showPassword('password', 'eye-new')"></i>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm New Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm New Password')" class="bi bi-lock-fill" />
                <div style="position: relative;">
                    <x-text-input id="password_confirmation" class="block mt-1 w-full pe-5"
                        type="password"
                        name="password_confirmation"
                        required
                        placeholder="Confirm your new password"
                        style="padding-right: 2.5rem;"
                    />
                    <span style="position: absolute; top: 50%; right: 1rem; transform: translateY(-50%); cursor: pointer; z-index: 2;">
                        <i class="bi bi-eye-fill" id="eye-confirm" onclick="showPassword('password_confirmation', 'eye-confirm')"></i>
                    </span>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Password Requirements -->
            <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-2"><strong>Password Requirements:</strong></p>
                <ul class="text-xs text-gray-500 space-y-1">
                    <li>• At least 8 characters long</li>
                    <li>• Contains at least one letter</li>
                    <li>• Contains at least one number</li>
                    <li>• Contains at least one symbol</li>
                </ul>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end mt-6">
                <x-primary-button class="w-full justify-center" style="background-color: #14532d; border-color: #14532d;">
                    {{ __('Change Password') }}
                </x-primary-button>
            </div>
        </form>

        <script>
            function showPassword(inputId, eyeId) {
                var x = document.getElementById(inputId);
                var eye = document.getElementById(eyeId);
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
    </div>
</x-guest-layout>
