<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordChangeController extends Controller
{
    /**
     * Display the password change form.
     */
    public function show(): View
    {
        return view('auth.password-change');
    }

    /**
     * Handle the password change request.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Validate the request
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/'
            ],
        ], [
            'current_password.required' => 'Please enter your current password.',
            'password.required' => 'Please enter a new password.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.regex' => 'Password must contain at least one letter, one number, and one symbol.',
        ]);

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Check if new password is different from current password
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The new password must be different from the current password.']);
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $user->markPasswordChanged();
        $user->save();

        return redirect()->route('dashboard')
            ->with('success', 'Password changed successfully!');
    }
}
