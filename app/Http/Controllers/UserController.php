<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PendingUser;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $verified = $request->input('verified');
        $blocked = $request->input('blocked');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->whereRaw("CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?", ["%{$search}%"])
                      ->orWhere('first_name', 'like', "%{$search}%")
                      ->orWhere('middle_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($verified !== null && $verified !== '', function ($query) use ($verified) {
                if ($verified === '1') {
                    $query->whereNotNull('email_verified_at');
                } elseif ($verified === '0') {
                    $query->whereNull('email_verified_at');
                }
            })
            ->when($blocked !== null && $blocked !== '', function ($query) use ($blocked) {
                if ($blocked === '1') {
                    $query->whereNotNull('login_blocked_until');
                } elseif ($blocked === '0') {
                    $query->whereNull('login_blocked_until');
                }
            })
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        $pendingUsers = PendingUser::where('approval_status', 'pending')
            ->when($search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'asc')
            ->get();

        return view('users.index', compact('users', 'pendingUsers', 'search', 'verified', 'blocked'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'organization' => 'required|string|exists:ref_organizations,organization_code',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'session_id' => 'nullable|string|max:255',
        ]);

        // Only destroy session if not the current user
        if (
            empty($validated['session_id']) &&
            $user->session_id &&
            (int)$user->id !== (int)auth()->id()
        ) {
            \Illuminate\Support\Facades\Session::getHandler()->destroy($user->session_id);
            $validated['session_id'] = null;
        }

        // Only set email_verified_at to null if the email actually changed
        if ($validated['email'] !== $user->email) {
            $user->email_verified_at = null;
        }

        $user->update($validated);

        // Handle password change if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $user->save();

            // If the updated user is the currently logged-in user, log them out
            if ((int)$user->id === (int)auth()->id()) {
                \Illuminate\Support\Facades\Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('status', 'Password changed. Please log in again.');
            }
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if (auth()->id() == $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function logoutSession($id)
    {
        $user = User::findOrFail($id);
        if ($user->session_id) {
            Session::getHandler()->destroy($user->session_id);
            $user->session_id = null;
            $user->save();
        }
        return redirect()->route('users.index')->with('success', 'User has been logged out.');
    }
}
