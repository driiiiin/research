<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                                <p class="text-sm font-medium text-gray-600">Total Health Researches</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_health_researches'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <!-- Recent Health Research -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Health Researches</h3>
                            <a href="{{ route('research.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($recent_health_researches as $healthResearch)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $healthResearch->title }}</h4>
                                        <p class="text-sm text-gray-600">by {{ $healthResearch->author }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        {{ $healthResearch->status === 'Available' ? 'bg-green-100 text-green-800' :
                                           ($healthResearch->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-800' :
                                           'bg-red-100 text-red-800') }}">
                                        {{ $healthResearch->status }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No health researches added yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
