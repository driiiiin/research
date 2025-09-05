<x-app-layout>
    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4 mb-2">
            <div class="flex items-center justify-between pt-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Health Research Management') }}
                </h2>
            </div>
            <!-- Quick Actions -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="flex flex-col md:flex-row gap-4 mx-2 my-2 px-2">
                        <a href="{{ route('research.health_researches.create') }}" class="flex flex-col items-center justify-center h-32 w-full md:w-1/4 bg-blue-50 rounded-xl shadow-sm hover:shadow-md hover:scale-105 transition-all duration-200 border border-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <span class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 mb-2 mt-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </span>
                            <span class="font-semibold text-blue-800 text-base">Add Health Research</span>
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
                            <option value="{{ $size }}" {{ request('per_page', $healthResearches->perPage()) == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    <span class="text-sm text-gray-700">entries</span>
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                </form>
                <form method="GET" class="flex items-center gap-2" id="searchForm">
                    @if(request('per_page'))
                        <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search health researches..." class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-300 text-sm" />
                    <button type="submit" class="ml-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Search</button>
                </form>
            </div>
            <!-- Health Research Table (List of Health Research) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Health Research List</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Health Research</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Copies</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($healthResearches as $healthResearch)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $healthResearch->title }}</div>
                                                <div class="text-sm text-gray-500">{{ $healthResearch->author }}</div>
                                                @if($healthResearch->isbn)
                                                    <div class="text-xs text-gray-400">ISBN: {{ $healthResearch->isbn }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $healthResearch->available_copies }}/{{ $healthResearch->total_copies }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $healthResearch->status === 'Available' ? 'bg-green-100 text-green-800' :
                                                   ($healthResearch->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-800' :
                                                   ($healthResearch->status === 'Lost' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                                {{ $healthResearch->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('research.health_researches.show', $healthResearch) }}"
                                                   class="text-blue-600 hover:text-blue-900">View</a>
                                                <a href="{{ route('research.health_researches.edit', $healthResearch) }}"
                                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form method="POST" action="{{ route('research.health_researches.destroy', $healthResearch) }}"
                                                      class="inline" onsubmit="return confirm('Are you sure you want to delete this health research?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No health researches found.
                                    </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-4 gap-2">
                        <div class="text-sm text-gray-600">
                            Showing
                            <span class="font-semibold">{{ $healthResearches->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-semibold">{{ $healthResearches->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-semibold">{{ $healthResearches->total() }}</span>
                            entries
                        </div>
                        <div>
                            {{ $healthResearches->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // On page load, if navigation type is reload, remove search param from URL and reload
        document.addEventListener('DOMContentLoaded', function() {
            if (performance && performance.getEntriesByType) {
                const navEntries = performance.getEntriesByType('navigation');
                if (navEntries.length > 0 && navEntries[0].type === 'reload') {
                    // Remove 'search' param from URL and reload
                    const url = new URL(window.location.href);
                    if (url.searchParams.has('search')) {
                        url.searchParams.delete('search');
                        // Also reset page param if present
                        url.searchParams.delete('page');
                        window.location.replace(url.toString());
                    }
                }
            } else if (performance && performance.navigation) {
                // Fallback for older browsers
                if (performance.navigation.type === 1) {
                    const url = new URL(window.location.href);
                    if (url.searchParams.has('search')) {
                        url.searchParams.delete('search');
                        url.searchParams.delete('page');
                        window.location.replace(url.toString());
                    }
                }
            }
        });
    </script>
</x-app-layout>
