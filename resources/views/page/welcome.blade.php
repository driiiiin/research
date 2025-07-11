<x-guest-layout>
    <nav class="w-full bg-[#14543A] shadow rounded-2xl mt-4 mb-6">
        <div class="flex items-center h-16 px-6 space-x-8">
            <a href="{{ route('welcome') }}" class="text-white text-lg font-medium hover:underline">Home</a>
            <a href="{{ route('contact') }}" class="text-white text-lg font-medium hover:underline">Contact</a>
            <a href="{{ route('about') }}" class="text-white text-lg font-medium hover:underline">About</a>
        </div>
    </nav>
    <div class="min-h-screen bg-gray-100 pt-3">
        <!-- Search Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('welcome') }}" class="mb-8" autocomplete="off">
                        <div class="flex flex-col md:flex-row md:space-x-4 space-y-2 md:space-y-0 items-center">
                            <div class="w-full md:w-1/2">
                                <input id="search" name="search" type="text" value="" placeholder="Title, Author, ISBN, or Genre"
                                    class="h-12 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 text-base" />
                            </div>
                            <div class="w-full md:w-1/4">
                                <select id="category" name="category" class="h-12 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 text-base">
                                    <option value="">All Categories</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full md:w-1/6">
                                <select id="format" name="format" class="h-12 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 text-base">
                                    <option value="">All Formats</option>
                                    <option value="Paperback">Paperback</option>
                                    <option value="Hardcover">Hardcover</option>
                                    <option value="E-book">E-book</option>
                                    <option value="Audiobook">Audiobook</option>
                                </select>
                            </div>
                            <div class="w-full md:w-auto flex items-center space-x-2 mt-2 md:mt-0">
                                <button type="submit" class="h-12 px-6 flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow transition font-semibold text-base">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search
                                </button>
                                <a href="{{ route('welcome') }}" class="h-12 px-6 flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg shadow transition font-semibold text-base">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Books Grid -->
                    @if(request('search') || request('category') || request('format'))
                        @if(isset($books) && $books->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach($books as $book)
                                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                @if($book->category)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                          style="background-color: {{ $book->category->color }}20; color: {{ $book->category->color }};">
                                                        {{ $book->category->name }}
                                                    </span>
                                                @endif
                                                <span class="text-xs text-gray-500">{{ $book->format }}</span>
                                            </div>

                                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $book->title }}</h3>
                                            <p class="text-sm text-gray-600 mb-3">by {{ $book->author }}</p>

                                            @if($book->description)
                                                <p class="text-sm text-gray-500 mb-4 line-clamp-3">{{ Str::limit($book->description, 100) }}</p>
                                            @endif

                                            <div class="flex items-center justify-between text-sm text-gray-500">
                                                <span>{{ $book->available_copies }}/{{ $book->total_copies }} available</span>
                                                @if($book->isbn)
                                                    <span class="text-xs">ISBN: {{ $book->isbn }}</span>
                                                @endif
                                            </div>

                                            @if($book->available_copies > 0)
                                                <div class="mt-4">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Available
                                                    </span>
                                                </div>
                                            @else
                                                <div class="mt-4">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Not Available
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            @if($books->hasPages())
                                <div class="mt-8">
                                    {{ $books->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No books found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria.</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Welcome to our Library</h3>
                            <p class="mt-1 text-sm text-gray-500">Search for books using the form above.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
