<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4" x-data="{ tab: 'to_submit' }">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Submit Books to External System</h1>
        <!-- Tab Navigation (Aligned like API tab) -->
        <div class="mb-6 border-b border-gray-200">
            <nav class="flex space-x-8 sm:-my-px sm:ms-10" aria-label="Tabs">
                <button type="button" @click="tab = 'to_submit'" :class="tab === 'to_submit' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none">
                    Books to Submit
                </button>
                <button type="button" @click="tab = 'submitted'" :class="tab === 'submitted' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none">
                    Submitted Books
                </button>
            </nav>
        </div>

        <!-- Books to Submit Tab -->
        <div x-show="tab === 'to_submit'">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                <form method="GET" class="flex items-center gap-2">
                    <label for="per_page" class="text-sm text-gray-700">Show</label>
                    <select name="per_page" id="per_page" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 text-sm">
                        @foreach([5, 10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', $books->perPage()) == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    <span class="text-sm text-gray-700">entries</span>
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                </form>
                <form method="GET" class="flex items-center gap-2">
                    @if(request('per_page'))
                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books..." class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 text-sm" />
                    <button type="submit" class="ml-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Search</button>
                </form>
            </div>
            <button id="submit-selected" class="mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Submit Selected</button>
            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2"><input type="checkbox" id="select-all"></th>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Author</th>
                            <th class="px-4 py-2">ISBN</th>
                            <th class="px-4 py-2">Publisher</th>
                            <th class="px-4 py-2">Year</th>
                            <th class="px-4 py-2">Edition</th>
                            <th class="px-4 py-2">Genre</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Total Copies</th>
                            <th class="px-4 py-2">Available</th>
                            <th class="px-4 py-2">Location</th>
                            <th class="px-4 py-2">Call #</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Language</th>
                            <th class="px-4 py-2">Pages</th>
                            <th class="px-4 py-2">Format</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Category</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($books as $book)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-center"><input type="checkbox" class="book-checkbox" data-book='@json($book)'></td>
                            <td class="px-4 py-2">{{ $book->id }}</td>
                            <td class="px-4 py-2 font-semibold text-gray-900">{{ $book->title }}</td>
                            <td class="px-4 py-2">{{ $book->author }}</td>
                            <td class="px-4 py-2">{{ $book->isbn }}</td>
                            <td class="px-4 py-2">{{ $book->publisher }}</td>
                            <td class="px-4 py-2">{{ $book->publication_year }}</td>
                            <td class="px-4 py-2">{{ $book->edition }}</td>
                            <td class="px-4 py-2">{{ $book->genre }}</td>
                            <td class="px-4 py-2 truncate max-w-xs" title="{{ $book->description }}">{{ \Illuminate\Support\Str::limit($book->description, 30) }}</td>
                            <td class="px-4 py-2">{{ $book->total_copies }}</td>
                            <td class="px-4 py-2">{{ $book->available_copies }}</td>
                            <td class="px-4 py-2">{{ $book->location }}</td>
                            <td class="px-4 py-2">{{ $book->call_number }}</td>
                            <td class="px-4 py-2">{{ $book->price }}</td>
                            <td class="px-4 py-2">{{ $book->language }}</td>
                            <td class="px-4 py-2">{{ $book->pages }}</td>
                            <td class="px-4 py-2">{{ $book->format }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $book->status === 'Available' ? 'bg-green-100 text-green-800' :
                                       ($book->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-800' :
                                       ($book->status === 'Lost' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                    {{ $book->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                @if($book->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        @if($book->category->color) style="color: {{ $book->category->color }};" @endif
                                    >
                                        {{ $book->category->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">No category</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center">
                                <button class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition btn-submit-book" data-book='@json($book)'>Submit</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="21" class="px-4 py-4 text-center text-gray-500">No books found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-4 gap-2">
                <div class="text-sm text-gray-600">
                    Showing
                    <span class="font-semibold">{{ $books->firstItem() ?? 0 }}</span>
                    to
                    <span class="font-semibold">{{ $books->lastItem() ?? 0 }}</span>
                    of
                    <span class="font-semibold">{{ $books->total() }}</span>
                    entries
                </div>
                <div>
                    {{ $books->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>

        <!-- Submitted Books Tab -->
        <div x-show="tab === 'submitted'">
            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Author</th>
                            <th class="px-4 py-2">ISBN</th>
                            <th class="px-4 py-2">Date Submitted</th>
                            <th class="px-4 py-2">Received Status</th>
                            <th class="px-4 py-2">Date Received</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($submittedBooks as $submitted)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $submitted->title }}</td>
                            <td class="px-4 py-2">{{ $submitted->author }}</td>
                            <td class="px-4 py-2">{{ $submitted->isbn }}</td>
                            <td class="px-4 py-2">{{ $submitted->submitted_at ? \Carbon\Carbon::parse($submitted->submitted_at)->format('Y-m-d H:i') : '-' }}</td>
                            <td class="px-4 py-2">{{ $submitted->received_status ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $submitted->received_at ? \Carbon\Carbon::parse($submitted->received_at)->format('Y-m-d H:i') : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">No submitted books found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $submittedBooks->appends(request()->except('submitted_page'))->links() }}
            </div>
        </div>
    </div>

    <!-- Modern Modal for Confirming Submission -->
    <div id="confirm-modal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-gray-200 bg-opacity-70 transition-opacity duration-200 hidden">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 md:mx-0 max-h-[90vh] flex flex-col border border-gray-100 animate-fade-in">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 rounded-t-2xl">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800">Confirm Book Submission</h2>
                <button id="modal-close" class="text-gray-400 hover:text-gray-600 text-2xl leading-none focus:outline-none">&times;</button>
            </div>
            <!-- Content -->
            <div id="modal-content" class="overflow-auto px-6 py-4 text-sm text-gray-700 flex-1">
                <!-- Book data table will be injected here -->
            </div>
            <!-- Footer -->
            <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-100 rounded-b-2xl bg-gray-50">
                <button id="modal-cancel" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Cancel</button>
                <button id="modal-confirm" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">Confirm & Submit</button>
            </div>
        </div>
    </div>
    <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(30px);} to { opacity: 1; transform: none; } }
        .animate-fade-in { animation: fade-in 0.25s cubic-bezier(.4,0,.2,1); }
    </style>

    <script>
    // Only clear search and per_page on true reload (F5/refresh)
    document.addEventListener('DOMContentLoaded', function() {
        let isReload = false;
        if (window.performance && window.performance.getEntriesByType) {
            const nav = window.performance.getEntriesByType('navigation')[0];
            if (nav && nav.type === 'reload') isReload = true;
        } else if (window.performance && window.performance.navigation) {
            // Fallback for older browsers
            if (window.performance.navigation.type === 1) isReload = true;
        }
        if (isReload) {
            const url = new URL(window.location.href);
            let changed = false;
            ['search', 'per_page'].forEach(param => {
                if (url.searchParams.has(param)) {
                    url.searchParams.delete(param);
                    changed = true;
                }
            });
            if (changed) {
                window.location.replace(url.pathname + url.search);
                return; // Prevent further JS from running on this load
            }
        }
        // Modal logic
        const modal = document.getElementById('confirm-modal');
        const modalContent = document.getElementById('modal-content');
        const modalConfirm = document.getElementById('modal-confirm');
        const modalCancel = document.getElementById('modal-cancel');
        const modalClose = document.getElementById('modal-close');
        let booksToSubmit = [];
        let isBatch = false;

        function showModal(books, batch = false) {
            booksToSubmit = books;
            isBatch = batch;
            // Build table
            let html = '';
            if (books.length === 1) {
                html += '<table class="min-w-full divide-y divide-gray-100 text-sm w-full">';
                for (const [key, value] of Object.entries(books[0])) {
                    html += `<tr><td class='font-medium pr-4 py-1 text-gray-700 whitespace-nowrap'>${key}</td><td class='py-1 break-all'>${value ?? ''}</td></tr>`;
                }
                html += '</table>';
            } else {
                // Multiple books: show as table
                const fields = Object.keys(books[0]);
                html += '<div class="overflow-x-auto"><table class="min-w-full divide-y divide-gray-100 text-sm"><thead><tr>';
                fields.forEach(f => html += `<th class='px-2 py-1 text-left font-medium text-gray-700 whitespace-nowrap'>${f}</th>`);
                html += '</tr></thead><tbody>';
                books.forEach(book => {
                    html += '<tr>';
                    fields.forEach(f => html += `<td class='px-2 py-1 break-all'>${book[f] ?? ''}</td>`);
                    html += '</tr>';
                });
                html += '</tbody></table></div>';
            }
            modalContent.innerHTML = html;
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.add('transition-opacity'); modal.style.opacity = 1; }, 10);
        }
        function hideModal() {
            modal.classList.add('hidden');
            booksToSubmit = [];
        }
        modalCancel.addEventListener('click', hideModal);
        modalClose.addEventListener('click', hideModal);
        // Dismiss modal on overlay click (but not modal itself)
        modal.addEventListener('click', function(e) {
            if (e.target === modal) hideModal();
        });
        // Confirm and submit
        modalConfirm.addEventListener('click', function() {
            const externalApiUrl = 'https://external-system.example.com/api/receive-book';
            fetch(externalApiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(isBatch ? booksToSubmit : booksToSubmit[0])
            })
            .then(response => {
                hideModal();
                if (response.ok) {
                    alert(isBatch ? 'Selected books submitted successfully!' : 'Book submitted successfully!');
                } else {
                    alert('Failed to submit ' + (isBatch ? 'selected books.' : 'book.'));
                }
            })
            .catch(error => {
                hideModal();
                alert('Error submitting ' + (isBatch ? 'selected books: ' : 'book: ') + error);
            });
        });

        // Per-row submit
        document.querySelectorAll('.btn-submit-book').forEach(function(button) {
            button.addEventListener('click', function() {
                const book = JSON.parse(this.getAttribute('data-book'));
                showModal([book], false);
            });
        });

        // Select all functionality
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.book-checkbox');
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });

        // Submit selected books
        document.getElementById('submit-selected').addEventListener('click', function() {
            const selectedBooks = Array.from(document.querySelectorAll('.book-checkbox:checked'))
                .map(cb => JSON.parse(cb.getAttribute('data-book')));
            if (selectedBooks.length === 0) {
                alert('Please select at least one book to submit.');
                return;
            }
            showModal(selectedBooks, true);
        });
    });
    </script>
</x-app-layout>
