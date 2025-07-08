<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $login = $this->input('login');
        $password = $this->input('password');
        $remember = $this->boolean('remember');

        // Check if login is email or username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Find the user first to check if they're blocked
        $user = User::where($field, $login)->first();

        if ($user) {
            // Check if user is blocked
            if ($user->login_blocked_until && $user->login_blocked_until->isFuture()) {
                $remainingMinutes = now()->diffInMinutes($user->login_blocked_until);
                throw ValidationException::withMessages([
                    'login' => "Account is temporarily blocked. Please try again in {$remainingMinutes} minutes.",
                ]);
            }

            // Reset failed logins if block period has expired
            if ($user->login_blocked_until && $user->login_blocked_until->isPast()) {
                $user->update([
                    'failed_logins' => 0,
                    'login_blocked_until' => null,
                ]);
            }
        }

        if (! Auth::attempt([$field => $login, 'password' => $password], $remember)) {
            // Increment failed login attempts
            if ($user) {
                $failedLogins = $user->failed_logins + 1;
                $user->update(['failed_logins' => $failedLogins]);

                // Block user after 5 failed attempts for 30 minutes
                if ($failedLogins >= 5) {
                    $user->update([
                        'login_blocked_until' => now()->addMinutes(30),
                    ]);

                    throw ValidationException::withMessages([
                        'login' => 'Too many failed login attempts. Account blocked for 30 minutes.',
                    ]);
                } else {
                    $remainingAttempts = 5 - $failedLogins;
                    throw ValidationException::withMessages([
                        'login' => "Invalid credentials. {$remainingAttempts} attempts remaining.",
                    ]);
                }
            } else {
                throw ValidationException::withMessages([
                    'login' => trans('auth.failed'),
                ]);
            }
        }

        // Reset failed logins on successful login
        if ($user) {
            $user->update([
                'failed_logins' => 0,
                'login_blocked_until' => null,
            ]);
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => __('auth.lockout_24h', [
                'hours' => 24,
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('login')).'|'.$this->ip());
    }
}
