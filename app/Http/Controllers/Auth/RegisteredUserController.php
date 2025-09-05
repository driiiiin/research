<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PendingUser;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'username' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z0-9_]+$/', 'unique:pending_users,username', 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:pending_users,email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::min(8)->letters()->numbers()->symbols(),
            ],
        ], [
            'first_name.regex' => 'First name can only contain letters and spaces.',
            'last_name.regex' => 'Last name can only contain letters and spaces.',
            'middle_name.regex' => 'Middle name can only contain letters and spaces.',
            'username.min' => 'Username must be at least 3 characters long.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'email.unique' => 'This email address is already registered.',
            'username.unique' => 'This username is already taken.',
            'password.min' => 'Password must be at least 8 characters long.',
        ]);

        $pendingUser = PendingUser::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'approval_status' => 'pending',
        ]);

        // Optionally, you can fire an event or notification here for admin approval

        // Pass a SweetAlert (Swal) trigger to the session
        return redirect(route('users.index', absolute: false))->with([
            'status' => 'Registration submitted! Please contact the administrator for approval.',
            'swal' => [
                'title' => 'Registration Submitted!',
                'text' => 'Please contact the administrator for approval.',
                'icon' => 'success',
                'button' => 'OK',
            ],
        ]);
    }

    /**
     * Check if an email already exists among users or pending users.
     */
    public function checkEmailUnique(Request $request)
    {
        $email = (string) $request->query('email', '');
        $exists = false;

        if ($email !== '') {
            $exists = PendingUser::where('email', $email)->exists()
                || User::where('email', $email)->exists();
        }

        return response()->json(['exists' => $exists]);
    }

    /**
     * Check if a username already exists among users or pending users.
     */
    public function checkUsernameUnique(Request $request)
    {
        $username = (string) $request->query('username', '');
        $exists = false;

        if ($username !== '') {
            $exists = PendingUser::where('username', $username)->exists()
                || User::where('username', $username)->exists();
        }

        return response()->json(['exists' => $exists]);
    }
}
