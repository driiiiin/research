@php
    $hasFilter = request('search') || request('category') || request('status');
@endphp
<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
        <!-- Search and Filter Form -->
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-800">Search Books</h3>
            <form method="GET" action="{{ route('library.books.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <x-input-label for="search" value="Search" />
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full"
                            value="{{ request('search') }}" placeholder="Title, Author, or ISBN" />
                    </div>
                    <div>
                        <x-input-label for="category" value="Category" />
                        <select id="category" name="category" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">All Status</option>
                            <option value="Available" {{ request('status') === 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Borrowed" {{ request('status') === 'Borrowed' ? 'selected' : '' }}>Borrowed</option>
                            <option value="Maintenance" {{ request('status') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="Lost" {{ request('status') === 'Lost' ? 'selected' : '' }}>Lost</option>
                        </select>
                    </div>
                    <div class="flex items-end mb-2 space-x-2">
                        <x-primary-button type="submit">
                            {{ __('SEARCH') }}
                        </x-primary-button>
                        <a href="{{ route('library.books.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring focus:ring-gray-200 active:bg-gray-400 disabled:opacity-25 transition">Clear</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- Books Table (List of Books) -->
        @if(request('search') || request('category') || request('status'))
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6" style="padding-top:0">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Search Result</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
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
                                <tr>
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
                                            @php $style = 'background-color: ' . $book->category->color . '20; color: ' . $book->category->color . ';'; @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="{{ $style }}">
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
                @if($books->hasPages())
                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                @endif
            </div>
        </div>
        @else
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
            <div class="p-6 text-center text-gray-500">
                Please use the search form above to find books.
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
