<?php

namespace App\Http\Controllers;

use App\Models\PendingUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminPendingUserController extends Controller
{
    // Show all pending users
    public function index()
    {
        $pendingUsers = PendingUser::where('approval_status', 'pending')->get();
        return view('admin.users.pending', compact('pendingUsers'));
    }

    // Approve a pending user
    public function approve($id)
    {
        $pendingUser = PendingUser::findOrFail($id);
        // Move to users table
        $user = User::create([
            'name' => $pendingUser->first_name . ' ' . trim(($pendingUser->middle_name ? $pendingUser->middle_name . ' ' : '') . $pendingUser->last_name),
            'first_name' => $pendingUser->first_name,
            'last_name' => $pendingUser->last_name,
            'middle_name' => $pendingUser->middle_name,
            'organization' => $pendingUser->organization,
            'username' => $pendingUser->username,
            'email' => $pendingUser->email,
            'password' => $pendingUser->password, // Already hashed
        ]);
        $pendingUser->approval_status = 'approved';
        $pendingUser->save();
        $pendingUser->delete();
        return redirect()->route('users.index')->with('status', 'User approved and added to users table.');
    }

    // Reject a pending user
    public function reject($id)
    {
        $pendingUser = PendingUser::findOrFail($id);
        $pendingUser->delete();
        return redirect()->route('admin.pending-users.index')->with('status', 'User rejected and removed from pending list.');
    }
}
