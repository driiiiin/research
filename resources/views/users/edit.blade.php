<x-app-layout>
    <div class="max-w-2xl mx-auto py-8">
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-xl font-bold text-primary">Edit User</h3>
                <a href="{{ route('users.index') }}" class="text-blue-600 hover:underline">Back to List</a>
            </div>
            <form method="POST" action="{{ route('users.update', $user->id) }}" class="p-6 space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-gray-700">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <div>
                    <label class="block text-gray-700">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                </div>
                <div>
                    <label class="block text-gray-700">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <div>
                    <label class="block text-gray-700">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <div>
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <div>
                    <label class="block text-gray-700">Organization</label>
                    <select name="organization" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="" disabled {{ old('organization', $user->organization) ? '' : 'selected' }}>Select your organization</option>
                        @foreach(\App\Models\ref_organizations::orderBy('organization_desc')->get() as $org)
                            <option value="{{ $org->organization_code }}" {{ old('organization', $user->organization) == $org->organization_code ? 'selected' : '' }}>{{ $org->organization_desc }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">New Password</label>
                    <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" autocomplete="new-password" />
                </div>
                <div>
                    <label class="block text-gray-700">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" autocomplete="new-password" />
                </div>
                <div class="text-sm text-gray-500 mb-2">Leave password fields blank to keep the current password.</div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
