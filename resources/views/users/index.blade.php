<x-app-layout>
    <div class="max-w-6xl mx-auto py-8">
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-xl font-bold text-primary">User Management</h3>
            </div>
            <div class="p-6">
                <div class="mb-4 flex gap-2">
                    <button id="approvedTabBtn" class="px-4 py-2 rounded-lg text-sm font-semibold bg-blue-600 text-white focus:outline-none">Approved Users</button>
                    <button id="pendingTabBtn" class="px-4 py-2 rounded-lg text-sm font-semibold bg-gray-200 text-gray-700 focus:outline-none">Pending Users</button>
                </div>
                <div id="approvedTab" class="block">
                    <form method="GET" action="{{ route('users.index') }}" class="mb-4 flex gap-2 flex-wrap items-center">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="border rounded px-3 py-2 w-64" />
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Search</button>
                    </form>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No.</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Username</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-3 text-gray-700">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $user->full_name }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $user->username }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $user->email }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('users.show', $user->id) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-semibold rounded shadow-sm transition">Show</a>
                                            <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white text-xs font-semibold rounded shadow-sm transition">Edit</a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-user-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded shadow-sm transition">Delete</button>
                                            </form>
                                            <form action="{{ route('users.logoutSession', $user->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-400 hover:bg-red-600 text-white text-xs font-semibold rounded shadow-sm transition">Force Logout</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-400 text-lg">No approved users.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
                <div id="pendingTab" class="hidden">
                    <form method="GET" action="{{ route('users.index') }}" class="mb-4 flex gap-2">
                        <input type="text" name="pending_search" value="{{ request('pending_search') }}" placeholder="Search pending users..." class="border rounded px-3 py-2 w-64" />
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Search</button>
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                    </form>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No.</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Username</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($pendingUsers as $user)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-4 py-3 text-gray-700">{{ ($pendingUsers->currentPage() - 1) * $pendingUsers->perPage() + $loop->iteration }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $user->username }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $user->email }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-2">
                                            <form action="{{ route('admin.pending-users.approve', $user->id) }}" method="POST" class="approve-user-form">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition approve-btn">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.pending-users.reject', $user->id) }}" method="POST" class="reject-user-form">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg shadow-sm transition reject-btn">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-400 text-lg">No pending users.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $pendingUsers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const approvedTabBtn = document.getElementById('approvedTabBtn');
        const pendingTabBtn = document.getElementById('pendingTabBtn');
        const approvedTab = document.getElementById('approvedTab');
        const pendingTab = document.getElementById('pendingTab');
        approvedTabBtn.addEventListener('click', () => {
            approvedTab.classList.remove('hidden');
            approvedTab.classList.add('block');
            pendingTab.classList.remove('block');
            pendingTab.classList.add('hidden');
            approvedTabBtn.classList.add('bg-blue-600', 'text-white');
            approvedTabBtn.classList.remove('bg-gray-200', 'text-gray-700');
            pendingTabBtn.classList.remove('bg-blue-600', 'text-white');
            pendingTabBtn.classList.add('bg-gray-200', 'text-gray-700');
        });
        pendingTabBtn.addEventListener('click', () => {
            approvedTab.classList.remove('block');
            approvedTab.classList.add('hidden');
            pendingTab.classList.remove('hidden');
            pendingTab.classList.add('block');
            pendingTabBtn.classList.add('bg-blue-600', 'text-white');
            pendingTabBtn.classList.remove('bg-gray-200', 'text-gray-700');
            approvedTabBtn.classList.remove('bg-blue-600', 'text-white');
            approvedTabBtn.classList.add('bg-gray-200', 'text-gray-700');
        });
        document.querySelectorAll('.delete-user-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            // Detect if the page was reloaded (F5 or browser refresh)
            let isReload = false;
            if (performance.getEntriesByType) {
                const navEntries = performance.getEntriesByType('navigation');
                if (navEntries.length > 0 && navEntries[0].type === 'reload') {
                    isReload = true;
                }
            } else if (performance.navigation) {
                // Fallback for older browsers
                isReload = performance.navigation.type === 1;
            }
            if (isReload) {
                const url = new URL(window.location.href);
                let changed = false;
                if (url.searchParams.has('search')) {
                    url.searchParams.delete('search');
                    changed = true;
                }
                if (url.searchParams.has('pending_search')) {
                    url.searchParams.delete('pending_search');
                    changed = true;
                }
                if (changed) {
                    window.location.replace(url.pathname + url.search);
                }
            }
        });
    </script>
</x-app-layout>
