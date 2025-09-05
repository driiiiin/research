<x-app-layout>
    <div class="max-w-6xl mx-auto py-8">
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-xl font-bold text-primary">User Management</h3>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-10 h-10 bg-primary hover:bg-[#14532d] text-primary border border-primary hover:text-white transition rounded-full shadow focus:outline-none" title="Add User Account">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="11" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v10m5-5H7" />
                    </svg>
                </a>
            </div>
            <div class="p-6">
                <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                    <div class="flex gap-2">
                        <button id="approvedTabBtn" class="px-4 py-2 rounded-lg text-sm font-semibold bg-blue-600 text-white focus:outline-none">Approved Users</button>
                        <button id="pendingTabBtn" class="px-4 py-2 rounded-lg text-sm font-semibold bg-gray-200 text-gray-700 focus:outline-none">Pending Users</button>
                    </div>
                    <form method="GET" action="{{ route('users.index') }}" class="flex items-center gap-2 mt-2 md:mt-0">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search users..."
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 text-sm" />
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            Search
                        </button>
                    </form>
                </div>
                <div id="approvedTab" class="block">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No.</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Username</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
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
                                <td class="px-4 py-3 text-gray-700">
                                    @if($user->session_id)
                                    <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">Logged In</span>
                                    @else
                                    <span class="inline-block px-2 py-1 text-xs font-semibold bg-gray-200 text-gray-600 rounded">Logged Out</span>
                                    @endif
                                </td>
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
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400 text-lg">No approved users.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
                <div id="pendingTab" class="hidden">
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
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.pending-users.reject', $user->id) }}" method="POST" class="reject-user-form">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg shadow-sm transition reject-btn">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
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

        // Restore last active tab from localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const lastTab = localStorage.getItem('userTab') || 'approved';
            if (lastTab === 'pending') {
                pendingTabBtn.click();
            } else {
                approvedTabBtn.click();
            }
        });

        approvedTabBtn.addEventListener('click', () => {
            approvedTab.classList.remove('hidden');
            approvedTab.classList.add('block');
            pendingTab.classList.remove('block');
            pendingTab.classList.add('hidden');
            approvedTabBtn.classList.add('bg-blue-600', 'text-white');
            approvedTabBtn.classList.remove('bg-gray-200', 'text-gray-700');
            pendingTabBtn.classList.remove('bg-blue-600', 'text-white');
            pendingTabBtn.classList.add('bg-gray-200', 'text-gray-700');
            localStorage.setItem('userTab', 'approved');
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
            localStorage.setItem('userTab', 'pending');
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
            // Only run on reload (not after form submit or navigation)
            let isReload = false;
            if (performance.getEntriesByType) {
                const navEntries = performance.getEntriesByType('navigation');
                if (navEntries.length > 0 && navEntries[0].type === 'reload') {
                    isReload = true;
                }
            } else if (performance.navigation) {
                isReload = performance.navigation.type === 1;
            }
            if (isReload) {
                const url = new URL(window.location.href);
                let changed = false;
                // Remove main users pagination
                if (url.searchParams.has('page')) {
                    url.searchParams.delete('page');
                    changed = true;
                }
                // Remove pending users pagination
                if (url.searchParams.has('pending_page')) {
                    url.searchParams.delete('pending_page');
                    changed = true;
                }
                // Remove search parameters
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
