<x-guest-layout>
    <!-- Logo and Title on the Top Left -->
    <!-- <div class="d-flex align-items-center mb-4" style="margin-left: .8rem; margin-top: 1.5rem;">
        <img src="{{ asset('images/DOH-logo.png') }}" alt="DOH Logo" style="height: 48px; margin-right: 0.75rem;" onerror="this.style.display='none'">
        <div>
            <h1 class="fw-bold mb-0" style="font-size: 1rem; letter-spacing: 2px; color: #14532d;">{{ str_replace('_', ' ', config('app.name', 'Health Research')) }}</h1>
            <div class="text-muted" style="font-size: 0.9rem;">Department of Health.</div>
        </div>
        <img src="{{ asset('images/BP-logo.png') }}" alt="BP Logo" style="height: 63px; margin-right: 0.75rem;" onerror="this.style.display='none'">
    </div> -->
    <div class="mt-2 p-4 m-4 mx-auto shadow-lg rounded relative" style="max-width: 500px;">
        <!-- X Button for Cancel/Close -->
        <a href="{{ route('users.index') }}"
           title="Cancel Registration"
           class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl font-bold focus:outline-none"
           style="text-decoration: none; line-height: 1;">
            &times;
        </a>
        <div class="mb-4 text-center">
            <h2 class="fw-semibold" style="font-size: 1.5rem;">Register</h2>
            <!-- <p class="text-muted" style="font-size: 1rem;">Create User Account</p> -->
            <!-- <p class="text-sm text-gray-500 mt-1"><span class="text-red-500">*</span> Required fields</p> -->
        </div>
        <form method="POST" action="{{ route('register') }}" id="registrationForm" novalidate>
            @csrf

            <!-- First Name -->
            <div>
                <div class="flex items-center">
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <span class="text-red-500 ml-1">*</span>
                </div>
                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" />
                <div id="first_name_error" class="hidden mt-2 text-sm text-red-600"></div>
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <!-- Last Name -->
            <div class="mt-4">
                <div class="flex items-center">
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <span class="text-red-500 ml-1">*</span>
                </div>
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
                <div id="last_name_error" class="hidden mt-2 text-sm text-red-600"></div>
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>

            <!-- Middle Name -->
            <div class="mt-4">
                <x-input-label for="middle_name" :value="__('Middle Name (Optional)')" />
                <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" :value="old('middle_name')" autocomplete="additional-name" />
                <div id="middle_name_error" class="hidden mt-2 text-sm text-red-600"></div>
                <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
            </div>

            <!-- Username -->
            <div class="mt-4">
                <div class="flex items-center">
                    <x-input-label for="username" :value="__('Username')" />
                    <span class="text-red-500 ml-1">*</span>
                </div>
                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
                <div id="username_error" class="hidden mt-2 text-sm text-red-600"></div>
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <div class="flex items-center">
                    <x-input-label for="email" :value="__('Email')" class="bi bi-person-fill" />
                    <span class="text-red-500 ml-1">*</span>
                </div>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                <div id="email_error" class="hidden mt-2 text-sm text-red-600"></div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <div class="flex items-center">
                    <x-input-label for="password" :value="__('Password')" class="bi bi-lock-fill" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <div id="password_error" class="hidden mt-2 text-sm text-red-600"></div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <!-- Password Requirements -->
                <div class="mt-2">
                    <p class="text-sm text-gray-600 mb-2"><strong>Password Requirements:</strong></p>
                    <ul class="text-xs text-gray-500 space-y-1">
                        <li id="req_length" class="flex items-center">
                            <span class="mr-2">•</span>
                            <span>At least 8 characters long</span>
                            <span id="length_check" class="ml-auto"></span>
                        </li>
                        <li id="req_letter" class="flex items-center">
                            <span class="mr-2">•</span>
                            <span>Contains at least one letter</span>
                            <span id="letter_check" class="ml-auto"></span>
                        </li>
                        <li id="req_number" class="flex items-center">
                            <span class="mr-2">•</span>
                            <span>Contains at least one number</span>
                            <span id="number_check" class="ml-auto"></span>
                        </li>
                        <li id="req_symbol" class="flex items-center">
                            <span class="mr-2">•</span>
                            <span>Contains at least one symbol</span>
                            <span id="symbol_check" class="ml-auto"></span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <div class="flex items-center">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <span class="text-red-500 ml-1">*</span>
                </div>

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <div id="password_confirmation_error" class="hidden mt-2 text-sm text-red-600"></div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a> -->

                <x-primary-button class="ms-4" id="submitBtn" type="submit">
                    <span id="submitText">{{ __('Register') }}</span>
                    <span id="submitLoading" class="hidden">Processing...</span>
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registrationForm');
            const submitBtn = document.getElementById('submitBtn');

            // Get all form fields
            const firstName = document.getElementById('first_name');
            const lastName = document.getElementById('last_name');
            // const middleName = document.getElementById('middle_name');
            const username = document.getElementById('username');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');

            // Get error display elements
            const firstNameError = document.getElementById('first_name_error');
            const lastNameError = document.getElementById('last_name_error');
            // const middleNameError = document.getElementById('middle_name_error');
            const usernameError = document.getElementById('username_error');
            const emailError = document.getElementById('email_error');
            const passwordError = document.getElementById('password_error');
            const passwordConfirmationError = document.getElementById('password_confirmation_error');

            // Password requirement check elements
            const lengthCheck = document.getElementById('length_check');
            const letterCheck = document.getElementById('letter_check');
            const numberCheck = document.getElementById('number_check');
            const symbolCheck = document.getElementById('symbol_check');

            // Validation state
            let isValid = {
                firstName: false,
                lastName: false,
                username: false,
                email: false,
                password: false,
                passwordConfirmation: false
            };

            // Helper function to show error
            function showError(element, message) {
                element.textContent = message;
                element.classList.remove('hidden');
                element.classList.add('block');
                resetSubmitButtonOnError();
            }

            // Helper function to hide error
            function hideError(element) {
                element.classList.add('hidden');
                element.classList.remove('block');
            }

            // Helper function to update password requirements
            function updatePasswordRequirements() {
                const value = password.value;

                // Length check
                if (value.length >= 8) {
                    lengthCheck.innerHTML = '✅';
                    lengthCheck.className = 'ml-auto text-green-500';
                } else {
                    lengthCheck.innerHTML = '❌';
                    lengthCheck.className = 'ml-auto text-red-500';
                }

                // Letter check
                if (/[a-zA-Z]/.test(value)) {
                    letterCheck.innerHTML = '✅';
                    letterCheck.className = 'ml-auto text-green-500';
                } else {
                    letterCheck.innerHTML = '❌';
                    letterCheck.className = 'ml-auto text-red-500';
                }

                // Number check
                if (/\d/.test(value)) {
                    numberCheck.innerHTML = '✅';
                    numberCheck.className = 'ml-auto text-green-500';
                } else {
                    numberCheck.innerHTML = '❌';
                    numberCheck.className = 'ml-auto text-red-500';
                }

                // Symbol check
                if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(value)) {
                    symbolCheck.innerHTML = '✅';
                    symbolCheck.className = 'ml-auto text-green-500';
                } else {
                    symbolCheck.innerHTML = '❌';
                    symbolCheck.className = 'ml-auto text-red-500';
                }
            }

                        // Validation functions
            function validateFirstName() {
                const value = firstName.value.trim();
                if (value.length === 0) {
                    showError(firstNameError, 'This field is required');
                    isValid.firstName = false;
                    return false;
                }
                if (value.length < 2) {
                    showError(firstNameError, 'First name must be at least 2 characters long');
                    isValid.firstName = false;
                    return false;
                }
                if (!/^[a-zA-Z\s]+$/.test(value)) {
                    showError(firstNameError, 'First name can only contain letters and spaces');
                    isValid.firstName = false;
                    return false;
                }
                hideError(firstNameError);
                isValid.firstName = true;
                return true;
            }

            function validateLastName() {
                const value = lastName.value.trim();
                if (value.length === 0) {
                    showError(lastNameError, 'This field is required');
                    isValid.lastName = false;
                    return false;
                }
                if (value.length < 2) {
                    showError(lastNameError, 'Last name must be at least 2 characters long');
                    isValid.lastName = false;
                    return false;
                }
                if (!/^[a-zA-Z\s]+$/.test(value)) {
                    showError(lastNameError, 'Last name can only contain letters and spaces');
                    isValid.lastName = false;
                    return false;
                }
                hideError(lastNameError);
                isValid.lastName = true;
                return true;
            }

            // function validateMiddleName() {
            //     const value = middleName.value.trim();
            //     if (value.length > 0 && value.length < 2) {
            //         showError(middleNameError, 'Middle name must be at least 2 characters long if provided');
            //         return false;
            //     }
            //     if (value.length > 0 && !/^[a-zA-Z\s]+$/.test(value)) {
            //         showError(middleNameError, 'Middle name can only contain letters and spaces');
            //         return false;
            //     }
            //     hideError(middleNameError);
            //     return true;
            // }

                        function validateUsername() {
                const value = username.value.trim();
                if (value.length === 0) {
                    showError(usernameError, 'This field is required');
                    isValid.username = false;
                    return false;
                }
                if (value.length < 3) {
                    showError(usernameError, 'Username must be at least 3 characters long');
                    isValid.username = false;
                    return false;
                }
                if (!/^[a-zA-Z0-9_]+$/.test(value)) {
                    showError(usernameError, 'Username can only contain letters, numbers, and underscores');
                    isValid.username = false;
                    return false;
                }

                // If format is valid, check uniqueness
                if (value.length >= 3 && /^[a-zA-Z0-9_]+$/.test(value)) {
                    checkUsernameUniqueness(value);
                    // Return true for format validation, uniqueness will be checked separately
                    return true;
                }

                return false;
            }

            function validateEmail() {
                const value = email.value.trim();
                if (value.length === 0) {
                    showError(emailError, 'This field is required');
                    isValid.email = false;
                    return false;
                }
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    showError(emailError, 'Please enter a valid email address');
                    isValid.email = false;
                    return false;
                }

                // If format is valid, check uniqueness
                if (emailRegex.test(value)) {
                    checkEmailUniqueness(value);
                    // Return true for format validation, uniqueness will be checked separately
                    return true;
                }

                return false;
            }

            // Function to check email uniqueness
            function checkEmailUniqueness(email) {
                // Show loading state
                emailError.textContent = 'Checking email availability...';
                emailError.classList.remove('hidden', 'text-blue-600');
                emailError.classList.add('block', 'text-red-600');

                // Make AJAX request to check email uniqueness
                fetch(`/check-email-unique?email=${encodeURIComponent(email)}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        showError(emailError, 'This email address is already registered');
                        isValid.email = false;
                    } else {
                        hideError(emailError);
                        isValid.email = true;
                    }
                })
                .catch(error => {
                    console.error('Error checking email uniqueness:', error);
                    // If there's an error, we'll let server-side validation handle it
                    hideError(emailError);
                    isValid.email = true;
                });
            }

            // Function to check username uniqueness
            function checkUsernameUniqueness(username) {
                // Show loading state
                usernameError.textContent = 'Checking username availability...';
                usernameError.classList.remove('hidden', 'text-blue-600');
                usernameError.classList.add('block', 'text-red-600');

                // Make AJAX request to check username uniqueness
                fetch(`/check-username-unique?username=${encodeURIComponent(username)}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        showError(usernameError, 'This username is already taken');
                        isValid.username = false;
                    } else {
                        hideError(usernameError);
                        isValid.username = true;
                    }
                })
                .catch(error => {
                    console.error('Error checking username uniqueness:', error);
                    // If there's an error, we'll let server-side validation handle it
                    hideError(usernameError);
                    isValid.username = true;
                });
            }

            function validatePassword() {
                const value = password.value;
                if (value.length === 0) {
                    showError(passwordError, 'This field is required');
                    isValid.password = false;
                    return false;
                }
                if (value.length < 8) {
                    showError(passwordError, 'Password must be at least 8 characters long');
                    isValid.password = false;
                    return false;
                }
                if (!/[a-zA-Z]/.test(value)) {
                    showError(passwordError, 'Password must contain at least one letter');
                    isValid.password = false;
                    return false;
                }
                if (!/\d/.test(value)) {
                    showError(passwordError, 'Password must contain at least one number');
                    isValid.password = false;
                    return false;
                }
                if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(value)) {
                    showError(passwordError, 'Password must contain at least one symbol');
                    isValid.password = false;
                    return false;
                }
                hideError(passwordError);
                isValid.password = true;
                return true;
            }

            function validatePasswordConfirmation() {
                const value = passwordConfirmation.value;
                if (value.length === 0) {
                    showError(passwordConfirmationError, 'This field is required');
                    isValid.passwordConfirmation = false;
                    return false;
                }
                if (value !== password.value) {
                    showError(passwordConfirmationError, 'Passwords do not match');
                    isValid.passwordConfirmation = false;
                    return false;
                }
                hideError(passwordConfirmationError);
                isValid.passwordConfirmation = true;
                return true;
            }

                        // Add event listeners for real-time validation
            firstName.addEventListener('input', validateFirstName);
            firstName.addEventListener('blur', validateFirstName);

            lastName.addEventListener('input', validateLastName);
            lastName.addEventListener('blur', validateLastName);

            middleName.addEventListener('input', validateMiddleName);
            middleName.addEventListener('blur', validateMiddleName);

            // Username validation with debouncing for uniqueness check
            let usernameTimeout;
            username.addEventListener('input', function() {
                clearTimeout(usernameTimeout);
                const value = username.value.trim();

                if (value.length === 0) {
                    showError(usernameError, 'This field is required');
                    isValid.username = false;
                } else if (value.length < 3) {
                    showError(usernameError, 'Username must be at least 3 characters long');
                    isValid.username = false;
                } else if (!/^[a-zA-Z0-9_]+$/.test(value)) {
                    showError(usernameError, 'Username can only contain letters, numbers, and underscores');
                    isValid.username = false;
                } else {
                    hideError(usernameError);
                    // Debounce the uniqueness check
                    usernameTimeout = setTimeout(() => {
                        checkUsernameUniqueness(value);
                    }, 500); // Wait 500ms after user stops typing
                }
            });
            username.addEventListener('blur', validateUsername);

            // Email validation with debouncing for uniqueness check
            let emailTimeout;
            email.addEventListener('input', function() {
                clearTimeout(emailTimeout);
                const value = email.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (value.length === 0) {
                    showError(emailError, 'This field is required');
                    isValid.email = false;
                } else if (!emailRegex.test(value)) {
                    showError(emailError, 'Please enter a valid email address');
                    isValid.email = false;
                } else {
                    hideError(emailError);
                    // Debounce the uniqueness check
                    emailTimeout = setTimeout(() => {
                        checkEmailUniqueness(value);
                    }, 500); // Wait 500ms after user stops typing
                }
            });
            email.addEventListener('blur', validateEmail);

            password.addEventListener('input', function() {
                updatePasswordRequirements();
                validatePassword();
                if (passwordConfirmation.value) {
                    validatePasswordConfirmation();
                }
            });
            password.addEventListener('blur', validatePassword);

            passwordConfirmation.addEventListener('input', validatePasswordConfirmation);
            passwordConfirmation.addEventListener('blur', validatePasswordConfirmation);

            // Function to check if all uniqueness validations have passed
            function checkAllUniquenessValid() {
                return isValid.username && isValid.email;
            }

            // Form submission validation
            form.addEventListener('submit', function(e) {
                // Run all validations
                const firstNameValid = validateFirstName();
                const lastNameValid = validateLastName();
                const middleNameValid = validateMiddleName();
                const usernameValid = validateUsername();
                const emailValid = validateEmail();
                const passwordValid = validatePassword();
                const passwordConfirmationValid = validatePasswordConfirmation();

                // Check if all required fields are valid
                if (!firstNameValid || !lastNameValid || !usernameValid || !emailValid || !passwordValid || !passwordConfirmationValid) {
                    e.preventDefault();

                    // Show general error message
                    if (!firstNameValid) firstName.focus();
                    else if (!lastNameValid) lastName.focus();
                    else if (!usernameValid) username.focus();
                    else if (!emailValid) email.focus();
                    else if (!passwordValid) password.focus();
                    else if (!passwordConfirmationValid) passwordConfirmation.focus();

                    // Scroll to first error
                    const firstError = document.querySelector('.text-red-600:not(.hidden)');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }

                    return false;
                }

                // Check if uniqueness validations have passed
                if (!checkAllUniquenessValid()) {
                    e.preventDefault();

                    // Show message about checking uniqueness
                    if (!isValid.username) {
                        username.focus();
                        showError(usernameError, 'Please wait for username availability check to complete');
                    } else if (!isValid.email) {
                        email.focus();
                        showError(emailError, 'Please wait for email availability check to complete');
                    }

                    return false;
                }

                // If all validations pass, show loading state
                const submitText = document.getElementById('submitText');
                const submitLoading = document.getElementById('submitLoading');

                submitText.classList.add('hidden');
                submitLoading.classList.remove('hidden');
                submitBtn.disabled = true;

                // Allow form submission
                return true;
            });

            // Function to reset submit button state
            function resetSubmitButton() {
                const submitText = document.getElementById('submitText');
                const submitLoading = document.getElementById('submitLoading');

                submitText.classList.remove('hidden');
                submitLoading.classList.add('hidden');
                submitBtn.disabled = false;
            }

            // Reset submit button on any validation error
            function resetSubmitButtonOnError() {
                resetSubmitButton();
            }

            // Initialize password requirements display
            updatePasswordRequirements();
        });
    </script>
</x-guest-layout>
