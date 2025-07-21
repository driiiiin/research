<x-guest-layout>
    <nav class="w-full bg-[#14543A] shadow rounded-2xl">
        <div class="flex items-center h-16 px-6 space-x-8">
            <a href="{{ route('welcome') }}" class="text-white text-lg font-medium hover:underline">Home</a>
            <a href="{{ route('contact') }}" class="text-white text-lg font-medium hover:underline">Contact</a>
            <a href="{{ route('about') }}" class="text-white text-lg font-medium hover:underline">About</a>
        </div>
    </nav>
    <div class="min-h-screen bg-white">
        <!-- Search Section -->
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('welcome') }}" class="mb-8" autocomplete="off">
                        <div class="flex flex-row items-center space-x-2 w-full">
                            <div class="flex-1 min-w-0">
                                <input id="search" name="search" type="text" value="" placeholder="Title, Author, ISBN, or Genre"
                                    class="h-12 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 text-base" />
                            </div>
                            <div class="w-48 min-w-[10rem]">
                                <select id="category" name="category" class="h-12 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 text-base">
                                    <option value="">All Categories</option>
                                    @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-40 min-w-[8rem]">
                                <select id="format" name="format" class="h-12 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 text-base">
                                    <option value="">All Formats</option>
                                    <option value="Paperback">Paperback</option>
                                    <option value="Hardcover">Hardcover</option>
                                    <option value="E-book">E-book</option>
                                    <option value="Audiobook">Audiobook</option>
                                </select>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button type="submit" class="h-12 px-6 flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow transition font-semibold text-base">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search
                                </button>
                                <a href="{{ url('/') }}" class="h-12 px-6 flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg shadow transition font-semibold text-base">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Welcome Message -->
                    @if(!request('search') && !request('category') && !request('format'))
                    <div class="text-center py-8" style="padding-top:0; padding-bottom:10px">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">Welcome to our Library</h3>
                        <p class="mt-1 text-base text-gray-500">Search for books using the form above.</p>
                    </div>

                    <!-- Carousel Section and About Health Research Repository Section -->
                    <div class="max-w-7xl mx-auto mb-8">
                        <div x-data="{ active: 0, images: ['/images/dohelib1.png', '/images/dohelib2.png', '/images/dohelib3.png'] }" x-init="setInterval(() => { active = active === images.length - 1 ? 0 : active + 1 }, 3000)">
                            <div class="relative overflow-hidden rounded-t-2xl shadow-lg">
                                <div class="flex transition-transform duration-500 ease-in-out" :style="'transform: translateX(-' + (active * 100) + '%)'">
                                    <template x-for="(img, idx) in images" :key="img">
                                        <img :src="img" class="w-full h-65 object-cover flex-shrink-0" />
                                    </template>
                                </div>
                                <!-- Prev Button -->
                                <button @click="active = active === 0 ? images.length - 1 : active - 1" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-700 rounded-full p-2 shadow focus:outline-none">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <!-- Next Button -->
                                <button @click="active = active === images.length - 1 ? 0 : active + 1" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-700 rounded-full p-2 shadow focus:outline-none">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                <!-- Indicators -->
                                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex space-x-2">
                                    <template x-for="(img, idx) in images" :key="'dot-' + idx">
                                        <button @click="active = idx" :class="{'bg-indigo-600': active === idx, 'bg-gray-300': active !== idx}" class="w-3 h-3 rounded-full focus:outline-none border-2 border-white"></button>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <!-- About Health Research Repository Section -->
                        <div class="bg-white rounded-b-2xl shadow-lg p-4 border border-gray-200">
                            <h2 class="text-2xl font-bold text-[#14543A] mb-4">About Health Research Repository</h2>
                            <p class="text-gray-700 mb-3">
                                The Health Research Repository, an initiative spearheaded by the Department of Health's Health Policy Development and Planning Bureau (HPDPB) in collaboration with the Knowledge Management and Information Technology Service (KMITS), shall serve as a centralized platform for collecting and managing crucial evidence from the Department's research initiatives. Its primary aim is to streamline the process of gathering, preserving, sharing, and applying essential health research findings within the Department.
                            </p>
                            <p class="text-gray-700 mb-3">
                                By leveraging advanced technologies and robust data management systems, this initiative seeks to enhance the efficiency and accessibility of vital health insights. The repository encourages collaboration and knowledge exchange among health professionals, empowering the Department to develop evidence-informed policies.
                            </p>
                            <p class="text-gray-700">
                                This strategic move reinforces the commitment to advancing healthcare through research, fostering a culture of continuous learning, and driving improvements in healthcare practices.
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Search Results Heading -->
                @if(request('search') || request('category') || request('format'))
                <div class="max-w-7xl mx-auto mb-4">
                    <h2 class="text-xl font-bold text-[#14543A]">Search Results</h2>
                    <div class="text-gray-600 text-sm mt-1">
                        @if(request('search'))
                        <span>Keyword: <span class="font-semibold">{{ request('search') }}</span></span>
                        @endif
                        @if(request('category'))
                        <span class="ml-2">Category: <span class="font-semibold">
                                {{ optional($categories->firstWhere('id', request('category')))->name ?? 'N/A' }}
                            </span></span>
                        @endif
                        @if(request('format'))
                        <span class="ml-2">Format: <span class="font-semibold">{{ request('format') }}</span></span>
                        @endif
                    </div>
                </div>
                @endif

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
                @endif
            </div>
        </div>
    </div>
    </div>
</x-guest-layout>
<script>
    // Detect if the page load is a reload/refresh
    let isReload = false;
    if (performance.getEntriesByType) {
        const navEntries = performance.getEntriesByType("navigation");
        if (navEntries.length > 0 && navEntries[0].type === "reload") {
            isReload = true;
        }
    } else if (performance.navigation) {
        // Deprecated, but still works in some browsers
        isReload = performance.navigation.type === 1;
    }

    // Only redirect to root URL if it's a refresh and there are query parameters
    if (isReload && window.location.search.length > 0) {
        window.location.href = '/';
    }
</script>
