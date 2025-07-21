<x-app-layout>
    <div class="max-w-2xl mx-auto py-8">
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-xl font-bold text-primary">User Details</h3>
                <a href="{{ route('users.index') }}" class="text-blue-600 hover:underline">Back to List</a>
            </div>
            <div class="p-6">
                <dl class="divide-y divide-gray-200">
                    <div class="py-3 flex justify-between">
                        <dt class="font-semibold text-gray-700">Full Name</dt>
                        <dd class="text-gray-900">{{ $user->full_name }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-semibold text-gray-700">Username</dt>
                        <dd class="text-gray-900">{{ $user->username }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-semibold text-gray-700">Email</dt>
                        <dd class="text-gray-900">{{ $user->email }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-semibold text-gray-700">Created At</dt>
                        <dd class="text-gray-900">{{ $user->created_at }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="font-semibold text-gray-700">Updated At</dt>
                        <dd class="text-gray-900">{{ $user->updated_at }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
