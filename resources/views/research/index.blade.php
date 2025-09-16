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
                        <!-- <a href="#" class="flex flex-col items-center justify-center h-32 w-full md:w-1/4 bg-pink-50 rounded-xl shadow-sm hover:shadow-md hover:scale-105 transition-all duration-200 border border-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-300">
                            <span class="flex items-center justify-center w-12 h-12 rounded-full bg-pink-100 mb-2 mt-2">
                                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16h8M8 12h8m-8-4h8M4 6h16M4 18h16"/>
                                </svg>
                            </span>
                            <span class="font-semibold text-pink-800 text-base">Add Policy Brief</span>
                        </a> -->
                    </div>
                </div>
            </div>
            <!-- Health Research Table (List of Health Research) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Health Research List</h3>
                    <div class="overflow-x-auto">
                        <!-- DataTables Bootstrap 5 CSS -->
                        <table id="researchTable" class="table table-striped w-full divide-y divide-gray-200 border border-gray-200 table-fixed">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[8%] min-w-[90px]">No.</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[40%] min-w-[320px]">Research Title / Subtitle</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[20%] min-w-[150px]">Authors</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[8%] min-w-[70px]">Year</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[10%] min-w-[90px]">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[15%] min-w-[120px]">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="researchTableBody" class="bg-white divide-y divide-gray-200">
                                @forelse($healthResearches as $index => $healthResearch)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 w-[8%] min-w-[90px]">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray-900 break-words w-[40%] min-w-[320px]">
                                            <div class="font-medium text-gray-900">
                                                {{ $healthResearch->research_title ?? $healthResearch->title ?? '-' }}
                                            </div>
                                            @if($healthResearch->research_subtitle ?? $healthResearch->subtitle ?? null)
                                            <div class="text-gray-600 text-xs mt-1">
                                                {{ $healthResearch->research_subtitle ?? $healthResearch->subtitle }}
                                            </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray-900 break-words w-[20%] min-w-[150px]">
                                            @if($healthResearch->relationLoaded('authors') || method_exists($healthResearch, 'authors'))
                                                {{ $healthResearch->authors->map(fn($a) => $a->full_name)->implode(', ') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 w-[8%] min-w-[70px]">
                                            {{ $healthResearch->date_issued_from_year ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap w-[10%] min-w-[90px]">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $healthResearch->status === 'Available' ? 'bg-green-100 text-green-800' :
                                                   ($healthResearch->status === 'Maintenance' ? 'bg-yellow-100 text-yellow-800' :
                                                   ($healthResearch->status === 'Lost' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                                {{ $healthResearch->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium w-[15%] min-w-[120px]">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('research.health_researches.show', $healthResearch) }}"
                                                   class="text-blue-600 hover:text-blue-900">View</a>
                                                <a href="{{ route('research.health_researches.edit', $healthResearch) }}"
                                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form method="POST" action="{{ route('research.health_researches.destroy', $healthResearch) }}"
                                                      class="inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="text-red-600 hover:text-red-900 delete-btn"
                                                            data-title="{{ $healthResearch->research_title }}">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Record Count -->
                    <div class="mt-6 px-6 pb-6">
                        <div class="text-sm text-gray-700">
                            Total: {{ $healthResearches->count() }} health research records
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let table = new DataTable('#researchTable', {
        responsive: true,
        order: [[0, 'desc']],
        paging: true,
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        language: {
            lengthMenu: "Show _MENU_ records per page",
            zeroRecords: "No health research records found",
            info: "Showing _START_ to _END_ of _TOTAL_ records",
            infoEmpty: "Showing 0 to 0 of 0 records",
            infoFiltered: "(filtered from _MAX_ total records)"
        }
    });

    // SweetAlert confirmation for delete buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Use event delegation to handle dynamically loaded delete buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-btn')) {
                e.preventDefault();

                const button = e.target;
                const form = button.closest('.delete-form');
                const title = button.getAttribute('data-title');

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete "${title}". This action cannot be undone!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Please wait while we delete the health research.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit the form
                        form.submit();
                    }
                });
            }
        });
    });
</script>
