<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-4" x-data="{ tab: 'to_submit' }">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Submit Health Research to External System</h1>
        <!-- Tab Navigation (Aligned like API tab) -->
        <div class="mb-6 border-b border-gray-200">
            <nav class="flex space-x-8 sm:-my-px sm:ms-10" aria-label="Tabs">
                <button type="button" @click="tab = 'to_submit'" :class="tab === 'to_submit' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none">
                    Health Research to Submit
                </button>
                <button type="button" @click="tab = 'submitted'" :class="tab === 'submitted' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none">
                    Submitted Health Research
                </button>
            </nav>
        </div>

        <!-- Health Research to Submit Tab -->
        <div x-show="tab === 'to_submit'">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
                <button id="submit-selected" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Submit Selected</button>
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-700">Show columns:</label>
                    <button id="toggle-columns" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm transition">Show All Columns</button>
                </div>
            </div>
            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table id="health-research-table" class="min-w-full divide-y divide-gray-200" style="width: 100%;">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2" style="width: 40px;"><input type="checkbox" id="select-all"></th>
                            <th class="px-4 py-2" style="width: 60px;">No.</th>
                            <th class="px-4 py-2" style="width: 260px;">Research Title</th>
                            <th class="px-4 py-2" style="width: 120px;">Source Type</th>
                            <th class="px-4 py-2" style="width: 140px;">Research Category</th>
                            <th class="px-4 py-2" style="width: 140px;">Research Type</th>
                            <th class="px-4 py-2" style="width: 120px;">Date Issued</th>
                            <th class="px-4 py-2" style="width: 110px;">Volume/Issue</th>
                            <th class="px-4 py-2" style="width: 80px;">Pages</th>
                            <th class="px-4 py-2" style="width: 160px;">DOI</th>
                            <th class="px-4 py-2" style="width: 180px;">Implementing Agency</th>
                            <th class="px-4 py-2" style="width: 100px;">Status</th>
                            <th class="px-4 py-2" style="width: 90px;">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- DataTables will populate this via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Submitted Health Research Tab -->
        <div x-show="tab === 'submitted'">
            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" style="width: 100%;">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2" style="width: 260px;">Research Title</th>
                            <th class="px-4 py-2" style="width: 120px;">Source Type</th>
                            <th class="px-4 py-2" style="width: 140px;">Research Category</th>
                            <th class="px-4 py-2" style="width: 140px;">Research Type</th>
                            <th class="px-4 py-2" style="width: 140px;">Date Submitted</th>
                            <th class="px-4 py-2" style="width: 120px;">Received Status</th>
                            <th class="px-4 py-2" style="width: 140px;">Date Received</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($submittedHealthResearches as $submitted)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 font-semibold text-gray-900" title="{{ $submitted->research_title }}">
                                {{ \Illuminate\Support\Str::limit($submitted->research_title, 50) }}
                            </td>
                            <td class="px-4 py-2">{{ $submitted->source_type }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $submitted->research_category }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $submitted->research_type }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $submitted->submitted_at ? \Carbon\Carbon::parse($submitted->submitted_at)->format('Y-m-d H:i') : '-' }}</td>
                            <td class="px-4 py-2">{{ $submitted->received_status ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $submitted->received_at ? \Carbon\Carbon::parse($submitted->received_at)->format('Y-m-d H:i') : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-gray-500">No submitted health research found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $submittedHealthResearches->appends(request()->except('submitted_page'))->links() }}
            </div>
        </div>
    </div>

    <!-- Modern Modal for Confirming Submission -->
    <div id="confirm-modal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-gray-200 bg-opacity-70 transition-opacity duration-200 hidden">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 md:mx-0 max-h-[90vh] flex flex-col border border-gray-100 animate-fade-in">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 rounded-t-2xl">
                <h2 class="text-lg md:text-xl font-semibold text-gray-800">Confirm Health Research Submission</h2>
                <button id="modal-close" class="text-gray-400 hover:text-gray-600 text-2xl leading-none focus:outline-none">&times;</button>
            </div>
            <!-- Content -->
            <div id="modal-content" class="overflow-auto px-6 py-4 text-sm text-gray-700 flex-1">
                <!-- Health Research data table will be injected here -->
            </div>
            <!-- Footer -->
            <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-100 rounded-b-2xl bg-gray-50">
                <button id="modal-cancel" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Cancel</button>
                <button id="modal-confirm" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">Confirm & Submit</button>
            </div>
        </div>
    </div>
    <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(30px);} to { opacity: 1; transform: none; } }
        .animate-fade-in { animation: fade-in 0.25s cubic-bezier(.4,0,.2,1); }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable
        let healthResearchTable;

        function initializeDataTable() {
            healthResearchTable = $('#health-research-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("health_researches.data") }}',
                    type: 'GET',
                    data: function(d) {
                        console.log('DataTable sending data:', d);
                        return d;
                    },
                    error: function(xhr, error, thrown) {
                        console.error('DataTable AJAX error:', error, thrown);
                        console.error('Response:', xhr.responseText);
                    }
                },
                columns: [
                    {
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '40px'
                    },
                    {
                        data: 'id',
                        name: 'id',
                        width: '60px',
                        className: 'text-center'
                    },
                    {
                        data: 'research_title',
                        name: 'research_title',
                        width: '260px',
                        className: 'text-left'
                    },
                    {
                        data: 'source_type',
                        name: 'source_type',
                        width: '120px',
                        className: 'text-left',
                        visible: false
                    },
                    {
                        data: 'research_category',
                        name: 'research_category',
                        width: '140px',
                        className: 'text-center'
                    },
                    {
                        data: 'research_type',
                        name: 'research_type',
                        width: '140px',
                        className: 'text-center'
                    },
                    {
                        data: 'date_issued',
                        name: 'date_issued_from_year',
                        width: '120px',
                        className: 'text-center',
                        visible: false
                    },
                    {
                        data: 'volume_issue',
                        name: 'volume_no',
                        width: '110px',
                        className: 'text-center',
                        visible: false
                    },
                    {
                        data: 'pages',
                        name: 'pages',
                        width: '80px',
                        className: 'text-center',
                        visible: false
                    },
                    {
                        data: 'doi',
                        name: 'doi',
                        width: '160px',
                        className: 'text-left',
                        visible: false
                    },
                    {
                        data: 'implementing_agency',
                        name: 'implementing_agency',
                        width: '180px',
                        className: 'text-left',
                        visible: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        width: '100px',
                        className: 'text-center',
                        visible: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '90px'
                    }
                ],
                order: [[1, 'desc']],
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                responsive: true,
                autoWidth: false,
                search: {
                    smart: true,
                    regex: false,
                    caseInsensitive: true
                },
                language: {
                    processing: "Loading health research data...",
                    emptyTable: "No health research found",
                    zeroRecords: "No matching health research found",
                    search: "Search:",
                    searchPlaceholder: "Search health research..."
                },
                drawCallback: function(settings) {
                    // Re-attach event listeners after table redraw
                    attachEventListeners();
                }
            });
        }

        // Modal logic
        const modal = document.getElementById('confirm-modal');
        const modalContent = document.getElementById('modal-content');
        const modalConfirm = document.getElementById('modal-confirm');
        const modalCancel = document.getElementById('modal-cancel');
        const modalClose = document.getElementById('modal-close');
        let healthResearchesToSubmit = [];
        let isBatch = false;

        function showModal(healthResearches, batch = false) {
            healthResearchesToSubmit = healthResearches;
            isBatch = batch;
            // Build table
            let html = '';
            if (healthResearches.length === 1) {
                html += '<table class="min-w-full divide-y divide-gray-100 text-sm w-full">';
                for (const [key, value] of Object.entries(healthResearches[0])) {
                    html += `<tr><td class='font-medium pr-4 py-1 text-gray-700 whitespace-nowrap'>${key}</td><td class='py-1 break-all'>${value ?? ''}</td></tr>`;
                }
                html += '</table>';
            } else {
                // Multiple health research: show as table
                const fields = Object.keys(healthResearches[0]);
                html += '<div class="overflow-x-auto"><table class="min-w-full divide-y divide-gray-100 text-sm" style="width:100%"><thead><tr>';
                fields.forEach(f => html += `<th class='px-2 py-1 text-left font-medium text-gray-700 whitespace-nowrap'>${f}</th>`);
                html += '</tr></thead><tbody>';
                healthResearches.forEach(healthResearch => {
                    html += '<tr>';
                    fields.forEach(f => html += `<td class='px-2 py-1 break-all'>${healthResearch[f] ?? ''}</td>`);
                    html += '</tr>';
                });
                html += '</tbody></table></div>';
            }
            modalContent.innerHTML = html;
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.add('transition-opacity'); modal.style.opacity = 1; }, 10);
        }
        function hideModal() {
            modal.classList.add('hidden');
            healthResearchesToSubmit = [];
        }
        modalCancel.addEventListener('click', hideModal);
        modalClose.addEventListener('click', hideModal);
        // Dismiss modal on overlay click (but not modal itself)
        modal.addEventListener('click', function(e) {
            if (e.target === modal) hideModal();
        });
        // Confirm and submit
        modalConfirm.addEventListener('click', function() {
            const externalApiUrl = 'https://external-system.example.com/api/receive-book';
            fetch(externalApiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(isBatch ? healthResearchesToSubmit : healthResearchesToSubmit[0])
            })
            .then(response => {
                hideModal();
                if (response.ok) {
                    alert(isBatch ? 'Selected health research submitted successfully!' : 'Health research submitted successfully!');
                } else {
                    alert('Failed to submit ' + (isBatch ? 'selected health research.' : 'health research.'));
                }
            })
            .catch(error => {
                hideModal();
                alert('Error submitting ' + (isBatch ? 'selected health research: ' : 'health research: ') + error);
            });
        });

        // Function to attach event listeners
        function attachEventListeners() {
            // Per-row submit
            document.querySelectorAll('.btn-submit-research').forEach(function(button) {
                button.addEventListener('click', function() {
                    const healthResearch = JSON.parse(this.getAttribute('data-research'));
                    showModal([healthResearch], false);
                });
            });

            // Select all functionality
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.research-checkbox');
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
            });
        }

        // Submit selected health research
        document.getElementById('submit-selected').addEventListener('click', function() {
            const selectedHealthResearches = Array.from(document.querySelectorAll('.research-checkbox:checked'))
                .map(cb => JSON.parse(cb.getAttribute('data-research')));
            if (selectedHealthResearches.length === 0) {
                alert('Please select at least one health research to submit.');
                return;
            }
            showModal(selectedHealthResearches, true);
        });

        // Toggle columns functionality
        document.getElementById('toggle-columns').addEventListener('click', function() {
            const button = this;
            const table = healthResearchTable;

            // Check if any hidden columns exist
            const hiddenColumns = [3, 6, 7, 8, 9, 10, 11]; // Column indices for hidden columns
            const hasHiddenColumns = hiddenColumns.some(index => !table.column(index).visible());

            if (hasHiddenColumns) {
                // Show all columns
                hiddenColumns.forEach(index => {
                    table.column(index).visible(true);
                });
                button.textContent = 'Hide Extra Columns';
                button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                button.classList.add('bg-gray-600', 'hover:bg-gray-700');
            } else {
                // Hide extra columns
                hiddenColumns.forEach(index => {
                    table.column(index).visible(false);
                });
                button.textContent = 'Show All Columns';
                button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                button.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }
        });

        // Initialize DataTable when the page loads
        initializeDataTable();
    });
    </script>
</x-app-layout>
