<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Book Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('library.books.edit', $book) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit Book
                </a>
                <a href="{{ route('library.books.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Back to Books
                </a>
            </div>
        </div>
    </x-slot>

    <div>
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Book Header -->
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                        <p class="text-xl text-gray-600 mb-4">by {{ $book->author }}</p>

                        <div class="flex items-center space-x-4">
                            @if($book->category)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                                      style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }};">
                                    {{ $book->category->name }}
                                </span>
                            @endif
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $book->status === 'Available' ? 'bg-green-100 text-green-800' :
                                   ($book->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-800' :
                                   ($book->status === 'Lost' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                {{ $book->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Book Information Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Basic Information</h3>
                            <dl class="space-y-3">
                                @if($book->isbn)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">ISBN</dt>
                                        <dd class="text-sm text-gray-900">{{ $book->isbn }}</dd>
                                    </div>
                                @endif
                                @if($book->publisher)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Publisher</dt>
                                        <dd class="text-sm text-gray-900">{{ $book->publisher }}</dd>
                                    </div>
                                @endif
                                @if($book->publication_year)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Publication Year</dt>
                                        <dd class="text-sm text-gray-900">{{ $book->publication_year }}</dd>
                                    </div>
                                @endif
                                @if($book->edition)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Edition</dt>
                                        <dd class="text-sm text-gray-900">{{ $book->edition }}</dd>
                                    </div>
                                @endif
                                @if($book->genre)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Genre</dt>
                                        <dd class="text-sm text-gray-900">{{ $book->genre }}</dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Language</dt>
                                    <dd class="text-sm text-gray-900">{{ $book->language }}</dd>
                                </div>
                                @if($book->pages)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Pages</dt>
                                        <dd class="text-sm text-gray-900">{{ $book->pages }}</dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Format</dt>
                                    <dd class="text-sm text-gray-900">{{ $book->format }}</dd>
                                </div>
                                @if($book->price)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Price</dt>
                                        <dd class="text-sm text-gray-900">${{ number_format($book->price, 2) }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Inventory Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Inventory Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Copies</dt>
                                    <dd class="text-sm text-gray-900">{{ $book->total_copies }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Available Copies</dt>
                                    <dd class="text-sm text-gray-900">{{ $book->available_copies }}</dd>
                                </div>
                                @if($book->location)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Location</dt>
                                        <dd class="text-sm text-gray-900">{{ $book->location }}</dd>
                                    </div>
                                @endif
                                @if($book->call_number)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Call Number</dt>
                                        <dd class="text-sm text-gray-900">{{ $book->call_number }}</dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Added</dt>
                                    <dd class="text-sm text-gray-900">{{ $book->created_at->format('M d, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="text-sm text-gray-900">{{ $book->updated_at->format('M d, Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($book->description)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Description</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                        </div>
                    @endif

                    <!-- Borrowing History -->
                    @if($book->borrowings->count() > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Borrowing History</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrowed</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Returned</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($book->borrowings as $borrowing)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $borrowing->user->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $borrowing->borrowed_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $borrowing->due_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $borrowing->returned_at ? $borrowing->returned_at->format('M d, Y') : '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        {{ $borrowing->status === 'Borrowed' ? 'bg-blue-100 text-blue-800' :
                                                           ($borrowing->status === 'Returned' ? 'bg-green-100 text-green-800' :
                                                           'bg-red-100 text-red-800') }}">
                                                        {{ $borrowing->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No borrowing history for this book.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
