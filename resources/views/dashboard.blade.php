@if(Auth::check() && (Auth::user()->organization == 'SuperAdmin' || Auth::user()->organization == '1'))
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-600">Total Health Researches</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['total_health_researches'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-600">Added in Last 7 Days</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['researches_added_7d'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-600">Submitted to External</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['submitted_researches'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-600">Pending Users</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['pending_users'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-600">Verified Users</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['verified_users'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-600">Survey Responses</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['survey_total'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-600">Survey Responses Today</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['survey_today'] }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Health Researches</h3>
                            <a href="{{ route('research.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($recent_health_researches as $item)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="min-w-0">
                                        <h4 class="truncate font-medium text-gray-900">{{ $item->research_title }}</h4>
                                        <p class="text-xs text-gray-500">Added {{ $item->created_at?->diffForHumans() }}</p>
                                    </div>
                                    <span class="ml-4 shrink-0 px-2 py-1 text-xs font-medium rounded-full {{
                                        $item->status === 'Available' ? 'bg-green-100 text-green-800' : (
                                        $item->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')
                                    }}">{{ $item->status }}</span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No health researches yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Users</h3>
                            <a href="{{ route('users.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Manage Users</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($recent_users as $user)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="min-w-0">
                                        <h4 class="truncate font-medium text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                    <span class="ml-4 shrink-0 px-2 py-1 text-xs font-medium rounded-full {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">{{ $user->email_verified_at ? 'Verified' : 'Unverified' }}</span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No users found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Submissions</h3>
                        </div>
                        <div class="space-y-3">
                            @forelse($recent_submissions as $sub)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="min-w-0">
                                        <h4 class="truncate font-medium text-gray-900">{{ $sub->title }}</h4>
                                        <p class="text-xs text-gray-500">Submitted {{ optional($sub->submitted_at)->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No submissions yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Survey Responses</h3>
                            <a href="{{ route('welcome') }}#survey" class="text-sm text-blue-600 hover:text-blue-800">Survey</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($recent_survey_responses as $sr)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="min-w-0">
                                        <h4 class="font-medium text-gray-900">{{ $sr->sex }} • {{ $sr->age }} • {{ $sr->sector }}</h4>
                                        <p class="text-xs text-gray-500">Satisfaction: {{ $sr->satisfaction }} • {{ $sr->created_at?->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No survey responses yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endif
