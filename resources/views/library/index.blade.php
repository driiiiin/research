<x-app-layout>
    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4 mb-2">
            <div class="flex items-center justify-between pt-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Books Management') }}
                </h2>
            </div>
            <!-- Quick Actions -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="{{ route('library.books.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="font-medium text-blue-800">Add Book</span>
                        </a>
                        <a href="{{ route('library.borrowings.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="font-medium text-green-800">Borrow Book</span>
                        </a>
                        <a href="{{ route('library.categories.create') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span class="font-medium text-purple-800">Add Category</span>
                        </a>
                        <a href="{{ route('library.books.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg class="w-6 h-6 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"></path>
                            </svg>
                            <span class="font-medium text-gray-800">Search</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Data Table Controls -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-8 mb-4 gap-4">
                <form method="GET" class="flex items-center gap-2">
                    <label for="per_page" class="text-sm text-gray-700">Show</label>
                    <select name="per_page" id="per_page" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 text-sm">
                        @foreach([5, 10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', $books->perPage()) == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    <span class="text-sm text-gray-700">entries</span>
                    <!-- @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                </form>
                <form method="GET" class="flex items-center gap-2">
                    @if(request('per_page'))
                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books..." class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 text-sm" />
                    <button type="submit" class="ml-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Search</button>
                </form> -->
            </div>
            <!-- Books Table (List of Books) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Books List</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Copies</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($books as $book)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                                                <div class="text-sm text-gray-500">{{ $book->author }}</div>
                                                @if($book->isbn)
                                                    <div class="text-xs text-gray-400">ISBN: {{ $book->isbn }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($book->category)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                      style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }};">
                                                    {{ $book->category->name }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-sm">No category</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $book->available_copies }}/{{ $book->total_copies }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $book->status === 'Available' ? 'bg-green-100 text-green-800' :
                                                   ($book->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-800' :
                                                   ($book->status === 'Lost' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                                {{ $book->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('library.books.show', $book) }}"
                                                   class="text-blue-600 hover:text-blue-900">View</a>
                                                <a href="{{ route('library.books.edit', $book) }}"
                                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form method="POST" action="{{ route('library.books.destroy', $book) }}"
                                                      class="inline" onsubmit="return confirm('Are you sure you want to delete this book?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            No books found.
                                        </td>
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
            </div>
        </div>
    </div>
</x-app-layout>
