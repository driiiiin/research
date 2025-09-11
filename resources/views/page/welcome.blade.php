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

    <!-- Quick Survey Modal -->
    <div id="quickSurveyModal" style="display:none; position:fixed; top:0; right:0; left:0; bottom:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:12px; max-width:500px; width:90%; margin:auto; padding:0; box-shadow:0 10px 25px rgba(0,0,0,0.3); position:relative;">
            <!-- Header -->
            <div style="background:#14543A; color:#fff; padding:20px 24px; border-radius:12px 12px 0 0; position:relative;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <h3 style="margin:0; font-size:20px; font-weight:600;">Quick Survey</h3>
                        <div style="margin-top:8px; color:#fff; font-size:14px;">
                            <strong>Dear Visitor</strong><br>
                            Thank you for visiting our website. Before you proceed, may we ask you to help us out on a survey to further improve our services.
                        </div>
                    </div>
                    <button onclick="closeSurveyModal()" style="position:absolute; right:16px; top:16px; background:none; border:none; color:#fff; font-size:24px; cursor:pointer; padding:4px; border-radius:4px; transition:background-color 0.2s;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.2)'" onmouseout="this.style.backgroundColor='transparent'">&times;</button>
                </div>
            </div>

            <!-- Form -->
            <form id="surveyForm" style="padding:24px;">
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:6px; font-weight:500; color:#374151;">1. Sex:</label>
                    <select name="sex" required style="width:100%; padding:10px; border:2px solid #e5e7eb; border-radius:6px; font-size:14px; background:#fff; transition:border-color 0.2s;" onfocus="this.style.borderColor='#14543A'" onblur="this.style.borderColor='#e5e7eb'">
                        <option value="">Select Sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:6px; font-weight:500; color:#374151;">2. Age:</label>
                    <select name="age" required style="width:100%; padding:10px; border:2px solid #e5e7eb; border-radius:6px; font-size:14px; background:#fff; transition:border-color 0.2s;" onfocus="this.style.borderColor='#14543A'" onblur="this.style.borderColor='#e5e7eb'">
                        <option value="">Select Age Range</option>
                        <option value="18 to 24">18 to 24</option>
                        <option value="25 to 34">25 to 34</option>
                        <option value="35 to 44">35 to 44</option>
                        <option value="45 to 54">45 to 54</option>
                        <option value="55 and above">55 and above</option>
                    </select>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:6px; font-weight:500; color:#374151;">3. From what sector:</label>
                    <select name="sector" required style="width:100%; padding:10px; border:2px solid #e5e7eb; border-radius:6px; font-size:14px; background:#fff; transition:border-color 0.2s;" onfocus="this.style.borderColor='#14543A'" onblur="this.style.borderColor='#e5e7eb'">
                        <option value="">Select Sector</option>
                        <option value="National Government Agency (NGA)">National Government Agency (NGA)</option>
                        <option value="Government-Owned and Controlled Corporation (GOCC)">Government-Owned and Controlled Corporation (GOCC)</option>
                        <option value="State Universities and College (SUC)">State Universities and College (SUC)</option>
                        <option value="Local Water District">Local Water District</option>
                        <option value="Local Government Unit (LGU)">Local Government Unit (LGU)</option>
                        <option value="Private">Private</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:6px; font-weight:500; color:#374151;">4. Reason/s for viewing/downloading the research/es:</label>
                    <select name="reason" required style="width:100%; padding:10px; border:2px solid #e5e7eb; border-radius:6px; font-size:14px; background:#fff; transition:border-color 0.2s;" onfocus="this.style.borderColor='#14543A'" onblur="this.style.borderColor='#e5e7eb'">
                        <option value="">Select Reason</option>
                        <option value="For policy formulation">For policy formulation</option>
                        <option value="For research and academic purposes">For research and academic purposes</option>
                        <option value="For reference in drafting official communication">For reference in drafting official communication</option>
                        <option value="For personal use">For personal use</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div style="margin-bottom:24px;">
                    <label style="display:block; margin-bottom:6px; font-weight:500; color:#374151;">5. How satisfied were you with this issuance?:</label>
                    <select name="satisfaction" required style="width:100%; padding:10px; border:2px solid #e5e7eb; border-radius:6px; font-size:14px; background:#fff; transition:border-color 0.2s;" onfocus="this.style.borderColor='#14543A'" onblur="this.style.borderColor='#e5e7eb'">
                        <option value="">Select Satisfaction Level</option>
                        <option value="5 - Very Satisfied">5 - Very Satisfied</option>
                        <option value="4 - Satisfied">4 - Satisfied</option>
                        <option value="3 - Neutral">3 - Neutral</option>
                        <option value="2 - Dissatisfied">2 - Dissatisfied</option>
                        <option value="1 - Very Dissatisfied">1 - Very Dissatisfied</option>
                    </select>
                </div>

                <div style="text-align:right;">
                    <button type="submit" style="background:#14543A; color:#fff; border:none; padding:12px 24px; border-radius:6px; font-size:14px; font-weight:500; cursor:pointer; transition:background-color 0.2s;" onmouseover="this.style.backgroundColor='#0f3d2a'" onmouseout="this.style.backgroundColor='#14543A'">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Message Modal -->
    <div id="successModal" style="display:none; position:fixed; top:0; right:0; left:0; bottom:0; background:rgba(0,0,0,0.5); z-index:10000; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:12px; max-width:400px; width:90%; margin:auto; padding:24px; box-shadow:0 10px 25px rgba(0,0,0,0.3); text-align:center;">
            <div style="color:#10b981; font-size:48px; margin-bottom:16px;">✓</div>
            <h3 style="margin:0 0 12px 0; color:#14543A; font-size:18px;">Thank You!</h3>
            <p style="margin:0 0 20px 0; color:#6b7280; font-size:14px;">Your feedback has been successfully recorded.</p>
            <button id="closeSuccessBtn" style="background:#14543A; color:#fff; border:none; padding:10px 20px; border-radius:6px; font-size:14px; cursor:pointer; transition:background-color 0.2s;" onmouseover="this.style.backgroundColor='#0f3d2a'" onmouseout="this.style.backgroundColor='#14543A'">
                Close
            </button>
        </div>
    </div>

    <!-- Hidden element to pass survey status to JavaScript -->
    <div id="survey-status"
         data-has-submitted="{{ $hasSubmittedSurvey ? 'true' : 'false' }}"
         data-has-seen-today="{{ $hasSeenSurveyToday ? 'true' : 'false' }}"
         style="display: none;"></div>
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

    // Survey functionality
    let surveyShown = false;
    const hasSubmittedSurvey = document.getElementById('survey-status').getAttribute('data-has-submitted') === 'true';
    const hasSeenSurveyToday = document.getElementById('survey-status').getAttribute('data-has-seen-today') === 'true';

    // Show survey after 5 seconds only if:
    // 1. IP hasn't submitted before
    // 2. IP hasn't seen survey today
    setTimeout(function() {
        if (!surveyShown && !hasSubmittedSurvey && !hasSeenSurveyToday) {
            showSurveyModal();
        }
    }, 10000);

    // Function to show survey modal
    function showSurveyModal() {
        const modal = document.getElementById('quickSurveyModal');
        if (modal) {
            modal.style.display = 'flex';
            surveyShown = true;

            // Mark survey as shown in database
            fetch('{{ route("survey.mark-shown") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            }).catch(error => {
                console.error('Error marking survey as shown:', error);
            });
        }
    }

    // Function to close survey modal
    function closeSurveyModal() {
        const modal = document.getElementById('quickSurveyModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Function to close success modal
    function closeSuccessModal() {
        const modal = document.getElementById('successModal');
        if (modal) {
            modal.style.display = 'none';
            console.log('Success modal closed');
        } else {
            console.log('Success modal not found');
        }
    }

    // Handle survey form submission
    document.getElementById('surveyForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        // Debug: Log form data
        console.log('Form data being sent:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }

        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;

        // Show loading state
        submitButton.textContent = 'Submitting...';
        submitButton.disabled = true;

        // Submit form via AJAX
        fetch('{{ route("survey.submit") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close survey modal
                closeSurveyModal();
                // Show success modal
                const successModal = document.getElementById('successModal');
                if (successModal) {
                    successModal.style.display = 'flex';
                    console.log('Success modal shown');
                }
            } else {
                alert(data.message || 'An error occurred. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        })
        .finally(() => {
            // Reset button state
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        });
    });

    // Close modals when clicking outside - ensure elements exist first
    const quickSurveyModal = document.getElementById('quickSurveyModal');
    const successModal = document.getElementById('successModal');

    if (quickSurveyModal) {
        quickSurveyModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeSurveyModal();
            }
        });
    }

    if (successModal) {
        successModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeSuccessModal();
            }
        });
    }

    // Add event listener for the close button
    const closeSuccessBtn = document.getElementById('closeSuccessBtn');
    if (closeSuccessBtn) {
        closeSuccessBtn.addEventListener('click', function() {
            closeSuccessModal();
        });
    }
});
</script>
