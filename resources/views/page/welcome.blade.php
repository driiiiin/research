<x-guest-layout>
    <nav class="w-full bg-[#14543A] shadow rounded-2xl mb-4">
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
                    <!-- Welcome Message -->
                    <div class="text-center py-8" style="padding-top:0; padding-bottom:10px">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">Welcome to our Health Research Repository</h3>
                    </div>
                <!-- Search Results Heading -->
                @if(request('search') || request('format'))
                <div class="max-w-7xl mx-auto mb-4">
                    <h2 class="text-xl font-bold text-[#14543A]">Search Results</h2>
                    <div class="text-gray-600 text-sm mt-1">
                        @if(request('search'))
                        <span>Keyword: <span class="font-semibold">{{ request('search') }}</span></span>
                        @endif
                        @if(request('format'))
                        <span class="ml-2">Format: <span class="font-semibold">{{ request('format') }}</span></span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Health Research Grid -->
                <div class="max-w-7xl mx-auto mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
                                <h3 class="text-lg font-semibold text-gray-800">Health Research List</h3>
                                <button
                                    id="printTableBtn"
                                    class="inline-flex items-center px-4 py-2 bg-[#14543A] hover:bg-[#17694a] text-white text-sm font-medium rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#14543A]"
                                    type="button"
                                    title="Print Table"
                                >
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-6 0v4m0 0h4m-4 0H8"/>
                                    </svg>
                                    Print Table
                                </button>
                            </div>
                            <div class="overflow-x-auto">
                                <table id="welcomeResearchTable" class="table table-striped w-full divide-y divide-gray-200 border border-gray-200 table-fixed">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Accession No</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[28%] min-w-[220px]">Title</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[18%] min-w-[150px]">Authors</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[7%] min-w-[60px]">Year</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse(($healthResearches ?? []) as $healthResearch)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray-900 break-words">
                                                {{ $healthResearch->accession_no ?? '-' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray-900 break-words w-[28%] min-w-[220px]">
                                                {{ $healthResearch->research_title ?? $healthResearch->title ?? '-' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray-900 break-words w-[18%] min-w-[150px]">
                                                @if(isset($healthResearch->authors) && is_iterable($healthResearch->authors) && count($healthResearch->authors))
                                                    {{ collect($healthResearch->authors)->map(fn($a) => $a->full_name ?? $a->name ?? $a)->implode(', ') }}
                                                @elseif(property_exists($healthResearch, 'author') && $healthResearch->author)
                                                    {{ $healthResearch->author }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 w-[7%] min-w-[60px]">
                                                {{ $healthResearch->date_issued_from_year ?? $healthResearch->year ?? '-' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ ($healthResearch->status ?? ($healthResearch->available_copies ?? 0) > 0 ? 'Available' : 'Not Available') === 'Available' ? 'bg-green-100 text-green-800' :
                                                       (($healthResearch->status ?? '') === 'Maintenance' ? 'bg-yellow-100 text-yellow-800' :
                                                       (($healthResearch->status ?? '') === 'Lost' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                                    {{ $healthResearch->status ?? (isset($healthResearch->available_copies) ? ($healthResearch->available_copies > 0 ? 'Available' : 'Not Available') : '-') }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ url('/research/details/' . ($healthResearch->accession_no ?? '')) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                            </td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                @if(!empty($healthResearches) && is_object($healthResearches) && method_exists($healthResearches, 'hasPages') && $healthResearches->hasPages())
                <div class="mt-8">
                    {{ $healthResearches->links() }}
                </div>
                @endif
                @if(empty($healthResearches) || count($healthResearches) === 0)
                    <div class="px-4 py-4 text-center text-gray-500">
                        No health researches found.
                    </div>
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
<script>
$(document).ready(function() {
    var $table = $('#welcomeResearchTable');
    if ($table.length) {
        // Debug: log the number of rows and columns
        console.log('Rows:', $table.find('tbody tr').length);
        $table.find('tbody tr').each(function(i, tr) {
            console.log('Row', i, 'columns:', $(tr).find('td').length);
        });
        new DataTable('#welcomeResearchTable', {
            responsive: true
        });
    }

    // Print button functionality
    $('#printTableBtn').on('click', function() {
        // Clone the table and remove DataTables styling for print
        var $tableClone = $('#welcomeResearchTable').clone();
        $tableClone.removeClass('dataTable').removeAttr('style');
        $tableClone.find('thead').removeClass();
        $tableClone.find('tbody tr').removeClass();
        $tableClone.find('td, th').removeClass();

        // Create a print window
        var printWindow = window.open('', '', 'width=900,height=700');
        var style = `
            <style>
                body { font-family: 'Inter', Arial, sans-serif; margin: 30px; color: #222; }
                h2 { color: #14543A; margin-bottom: 18px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                th, td { border: 1px solid #d1d5db; padding: 8px 12px; font-size: 14px; }
                th { background: #f3f4f6; color: #14543A; font-weight: 600; }
                tr:nth-child(even) { background: #f9fafb; }
                tr:hover { background: #f1f5f9; }
                .print-header { text-align: center; margin-bottom: 24px; }
                @media print {
                    body { margin: 0; }
                    .print-header { margin-bottom: 12px; }
                }
            </style>
        `;
        var header = `
            <div class="print-header">
                <h2>Health Research List</h2>
                <div style="font-size:13px; color:#555;">
                    Printed on: ${new Date().toLocaleString()}
                </div>
            </div>
        `;
        printWindow.document.write(`
            <html>
                <head>
                    <title>Print - Health Research List</title>
                    ${style}
                </head>
                <body>
                    ${header}
                    ${$tableClone.prop('outerHTML')}
                </body>
            </html>
        `);
        printWindow.document.close();
        setTimeout(function() {
            printWindow.focus();
            printWindow.print();
            // Optionally, close after print
            // printWindow.close();
        }, 400);
    });
});
</script>
