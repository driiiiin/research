<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between no-print">
            <h2 class="font-semibold text-2xl leading-tight tracking-tight" style="color: #14532d;">
                <span class="inline-flex items-center gap-2" style="color: #14532d;">
                    <svg class="w-7 h-7" style="color: #14532d;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    {{ __('Health Research Details') }}
                </span>
            </h2>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-emerald-50" style="padding-top: 0px;">
        <div class="max-w-5xl mx-auto px-4">
            <style>
                /* Enhanced form styling - compact */
                #health-research-details {
                    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                    box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.5);
                }

                /* Make all labels inside the form black and bold */
                #health-research-details label {
                    color: #1e293b !important;
                    font-weight: 600 !important;
                    font-size: 0.9rem;
                }

                /* Section header styling - compact */
                .section-header {
                    background: linear-gradient(135deg, #14532d 0%, #14532d 100%);
                    box-shadow: 0 3px 10px 0 rgba(20, 83, 45, 0.3);
                }

                /* Card styling for form sections - compact */
                .form-card {
                    background: #ffffff;
                    border: 1px solid #e2e8f0;
                    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1);
                    transition: all 0.3s ease;
                }

                .form-card:hover {
                    box-shadow: 0 8px 12px -3px rgba(0, 0, 0, 0.1);
                }

                /* Compact data field styling */
                .data-field {
                    background: #f8fafc;
                    border: 1px solid #e2e8f0;
                    transition: all 0.2s ease;
                }

                .data-field:hover {
                    background: #f1f5f9;
                    border-color: #cbd5e1;
                }

                /* Compact spacing */
                .compact-section {
                    margin-bottom: 1.5rem;
                }

                .compact-card {
                    padding: 1.5rem;
                }

                .compact-grid {
                    gap: 1rem;
                }

                /* Print styles */
                @media print {
                    body * {
                        visibility: hidden;
                    }

                    #health-research-details,
                    #health-research-details * {
                        visibility: visible;
                    }

                    #health-research-details {
                        position: absolute;
                        left: 0;
                        top: 0;
                        width: 100%;
                        background: white !important;
                        box-shadow: none !important;
                        padding: 20px !important;
                    }

                    .section-header {
                        background: #14532d !important;
                        color: white !important;
                        -webkit-print-color-adjust: exact;
                        print-color-adjust: exact;
                    }

                    .form-card {
                        break-inside: avoid;
                        page-break-inside: avoid;
                    }

                    .no-print {
                        display: none !important;
                    }
                }
            </style>
            <div id="health-research-details" class="bg-white rounded-3xl shadow-2xl px-8 pb-8 space-y-6">
                <div class="relative mb-6 pt-6">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold mb-2" style="color: #14532d;">Health Research Details</h2>
                        <p class="text-gray-600 text-sm">Complete information about this health research</p>
                    </div>
                    <div class="no-print absolute top-6 right-0 flex items-center space-x-2">
                        <button onclick="window.print()" class="text-gray-600 hover:text-gray-800 transition-colors duration-200 p-2 rounded-lg hover:bg-gray-100">
                            <i class="fa fa-print text-lg"></i>
                        </button>
                        <a href="{{ route('research.health_researches.edit', $healthResearch) }}" class="text-emerald-600 hover:text-emerald-800 transition-colors duration-200 p-2 rounded-lg hover:bg-emerald-50">
                            <i class="fa fa-edit text-lg"></i>
                        </a>
                        <a href="{{ route('research.health_researches.index') }}" class="text-gray-600 hover:text-gray-800 transition-colors duration-200 p-2 rounded-lg hover:bg-gray-100">
                            <i class="fa fa-arrow-left text-lg"></i>
                        </a>
                    </div>
                </div>
                <!-- TITLE Section -->
                <div class="w-full flex justify-center mb-4 mt-1">
                    <span class="section-header inline-flex items-center justify-center w-full px-4 py-2 rounded-lg">
                        <h3 class="text-lg font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            TITLE
                        </h3>
                    </span>
                </div>
                <div class="form-card rounded-2xl p-6">
                    <div class="flex flex-col lg:flex-row lg:items-end gap-6">
                        <div class="flex-shrink-0" style="display: inline-block; min-width: 220px; max-width: 100%;">
                            <div class="text-base font-semibold text-gray-800 mb-2">Accession No.</div>
                            <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium" style="height:40px; min-height:40px; max-width:350px;">
                                {{ $healthResearch->accession_no }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-semibold text-gray-800 mb-2">Research Title / Subtitle</div>
                            <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium" style="min-height:60px;">
                                @php
                                    $subtitle = $healthResearch->subtitle;
                                    $subtitleStr = '';
                                    if (!empty($subtitle)) {
                                        if (is_array($subtitle)) {
                                            $subtitleStr = implode(': ', $subtitle);
                                        } elseif (is_string($subtitle) && ($decoded = json_decode($subtitle, true)) && is_array($decoded)) {
                                            $subtitleStr = implode(': ', $decoded);
                                        } else {
                                            $subtitleStr = $subtitle;
                                        }
                                    }
                                @endphp
                                <strong class="text-lg">
                                    {{ $healthResearch->research_title }}@if($subtitleStr):@endif
                                </strong>
                                @if($subtitleStr)
                                    {{ ' ' . $subtitleStr }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- SOURCE Section -->
                <div class="w-full flex justify-center mb-4 mt-1">
                    <span class="section-header inline-flex items-center justify-center w-full px-4 py-2 rounded-lg">
                        <h3 class="text-lg font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            SOURCE
                        </h3>
                    </span>
                </div>

                <!-- Date Issued -->
                <div class="form-card rounded-2xl p-6">
                    <div class="text-sm font-semibold text-gray-800 mb-3">Date Issued</div>
                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium mb-3">
                        @php
                        $months = [
                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
                        7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                        ];
                        $fromMonth = $healthResearch->date_issued_from_month ?? null;
                        $toMonth = $healthResearch->date_issued_to_month ?? null;
                        @endphp
                        From: {{ $fromMonth && isset($months[$fromMonth]) ? $months[$fromMonth] : ($fromMonth ?: 'N/A') }}/{{ $healthResearch->date_issued_from_year }}
                        To: {{ $toMonth && isset($months[$toMonth]) ? $months[$toMonth] : ($toMonth ?: 'N/A') }}/{{ $healthResearch->date_issued_to_year }}
                    </div>
                </div>

                <!-- Publication Details -->
                <div class="form-card rounded-2xl p-6">
                    <div class="text-sm font-semibold text-gray-800 mb-4">Publication Details</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="text-xs font-medium text-gray-700 mb-1">Volume No.</div>
                            <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $healthResearch->volume_no ?: 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-700 mb-1">Issue No.</div>
                            <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $healthResearch->issue_no ?: 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-700 mb-1">Page(s)</div>
                            <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $healthResearch->pages ?: 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-700 mb-1">Article No.</div>
                            <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $healthResearch->article_no ?: 'N/A' }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <div class="text-xs font-medium text-gray-700 mb-1">DOI</div>
                            <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $healthResearch->doi ?: 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-700 mb-1">Implementing Agency</div>
                            <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $healthResearch->implementing_agency ?: 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-medium text-gray-700 mb-1">Cooperating Agency</div>
                            <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $healthResearch->cooperating_agency ?: 'N/A' }}</div>
                        </div>
                        <div class="md:col-span-2 mb-2">
                            <div class="text-xs font-medium text-gray-700 mb-1">Is this research funded by the government?</div>
                            <div class="inline-flex items-center px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-lg">
                                <span class="text-gray-700 font-medium text-sm">{{ $healthResearch->is_gov_fund == 'yes' ? 'Yes' : ($healthResearch->is_gov_fund == 'no' ? 'No' : 'Not specified') }}</span>
                            </div>
                        </div>
                        @if($healthResearch->is_gov_fund == 'yes' && $healthResearch->budget)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:col-span-2">
                            <div>
                                <div class="text-xs font-medium text-gray-700 mb-1">Research Budget</div>
                                <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">
                                    {{ $healthResearch->budget ? number_format($healthResearch->budget, 2) : 'N/A' }}
                                </div>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-700 mb-1">Currency</div>
                                <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">
                                    @php
                                    $currencyDesc = null;
                                    if (!empty($healthResearch->currency_code)) {
                                    $currency = \App\Models\ref_currency::where('currency_code', $healthResearch->currency_code)->first();
                                    $currencyDesc = $currency ? $currency->currency_desc : $healthResearch->currency_code;
                                    }
                                    @endphp
                                    {{ $currencyDesc ?: 'N/A' }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <div>
                            <div class="text-xs font-medium text-gray-700 mb-1">Funding Agency</div>
                            <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $healthResearch->funding_agency ?: 'N/A' }}</div>
                        </div>
                    </div>
                </div>
                <!-- Notes -->
                <div class="form-card rounded-2xl p-6">
                    <div class="text-sm font-semibold text-gray-800 mb-3">General Notes</div>
                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium" style="min-height: 80px;">
                        {{ $healthResearch->notes ?: 'No notes available' }}
                    </div>
                </div>

                <!-- Research Category -->
                <div class="form-card rounded-2xl p-6">
                    <div class="text-sm font-semibold text-gray-800 mb-3">Research Category</div>
                    <div class="inline-flex items-center px-3 py-2 bg-orange-50 border border-orange-200 rounded-lg">
                        <span class="text-gray-700 font-medium text-sm">{{ $healthResearch->research_category }}</span>
                    </div>
                </div>

                <!-- Research Type -->
                <div class="form-card rounded-2xl p-6">
                    <div class="text-sm font-semibold text-gray-800 mb-3">Research Type</div>
                    <div class="inline-flex items-center px-3 py-2 bg-orange-50 border border-orange-200 rounded-lg">
                        <span class="text-gray-700 font-medium text-sm">{{ $healthResearch->research_type }}</span>
                    </div>
                </div>
                <!-- AUTHOR Section -->
                <div class="w-full flex justify-center mb-4 mt-1">
                    <span class="section-header inline-flex items-center justify-center w-full px-4 py-2 rounded-lg">
                        <h3 class="text-lg font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            AUTHOR
                        </h3>
                    </span>
                </div>

                <div class="form-card rounded-2xl p-6">
                    @if(isset($healthResearch->authors) && is_iterable($healthResearch->authors))
                    <div class="space-y-3">
                        @foreach($healthResearch->authors as $index => $author)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="text-xs font-medium text-gray-700 mb-1">Last Name</div>
                                <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $author->last_name ?: 'N/A' }}</div>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-700 mb-1">First Name</div>
                                <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $author->first_name ?: 'N/A' }}</div>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-700 mb-1">Middle Name</div>
                                <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $author->middle_name ?: 'N/A' }}</div>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-700 mb-1">Suffix</div>
                                <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $author->suffix ?: 'N/A' }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">
                        {{ $healthResearch->author ?: 'No author information available' }}
                    </div>
                    @endif
                </div>
                <!-- ABSTRACT Section -->
                <div class="w-full flex justify-center mb-4 mt-1">
                    <span class="section-header inline-flex items-center justify-center w-full px-4 py-2 rounded-lg">
                        <h3 class="text-lg font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            ABSTRACT
                        </h3>
                    </span>
                </div>

                <div class="form-card rounded-2xl p-6">
                    <div class="mb-4">
                        <div class="text-xs font-medium text-gray-700 mb-1">Abstract Type</div>
                        <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $healthResearch->abstract_type ?: 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium text-gray-700 mb-1">Abstract Content</div>
                        <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium" style="min-height: 150px;">
                            {{ $healthResearch->research_abstract ?: 'No abstract available' }}
                        </div>
                    </div>
                </div>
                <!-- REFERENCE Section -->
                <div class="w-full flex justify-center mb-4 mt-1">
                    <span class="section-header inline-flex items-center justify-center w-full px-4 py-2 rounded-lg">
                        <h3 class="text-lg font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            REFERENCE / CITATION
                        </h3>
                    </span>
                </div>

                <div class="form-card rounded-2xl p-6">
                    <div class="text-sm font-semibold text-gray-800 mb-3">Reference / Citation</div>
                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium" style="min-height: 120px;">
                        {{ $healthResearch->reference ?: 'No reference available' }}
                    </div>
                </div>
                <!-- LOCATION Section -->
                <div class="w-full flex justify-center mb-4 mt-1">
                    <span class="section-header inline-flex items-center justify-center w-full px-4 py-2 rounded-lg">
                        <h3 class="text-lg font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            LOCATION
                        </h3>
                    </span>
                </div>

                <div class="form-card rounded-2xl p-6">
                    @if(isset($healthResearch->locations) && is_iterable($healthResearch->locations))
                    <div class="space-y-4">
                        @foreach($healthResearch->locations as $index => $location)
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="text-xs font-medium text-gray-700 mb-1">Format</div>
                                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $location->format ?: 'N/A' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs font-medium text-gray-700 mb-1">Physical Location</div>
                                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $location->physical_location ?: 'N/A' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs font-medium text-gray-700 mb-1">Location Number</div>
                                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $location->location_number ?: 'N/A' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs font-medium text-gray-700 mb-1">Text Availability</div>
                                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $location->text_availability ?: 'N/A' }}</div>
                                </div>
                                <div>
                                    <div class="text-xs font-medium text-gray-700 mb-1">Mode of Access</div>
                                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $location->mode_of_access ?: 'N/A' }}</div>
                                </div>
                                @if($location->institutional_email)
                                <div>
                                    <div class="text-xs font-medium text-gray-700 mb-1">Institutional Email</div>
                                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">{{ $location->institutional_email }}</div>
                                </div>
                                @endif
                                @if($location->url)
                                <div>
                                    <div class="text-xs font-medium text-gray-700 mb-1">URL</div>
                                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">
                                        <a href="{{ $location->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline text-xs">{{ $location->url }}</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium">
                        {{ $healthResearch->location ?: 'No location information available' }}
                    </div>
                    @endif
                </div>
                <!-- Status Section -->
                <div class="form-card rounded-2xl p-6">
                    <div class="text-sm font-semibold text-gray-800 mb-3">Status</div>
                    <div class="inline-flex items-center px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-lg">
                        <span class="text-gray-700 font-medium text-sm">{{ $healthResearch->status ?: 'No status available' }}</span>
                    </div>
                </div>

                <!-- SDG Section -->
                <div class="w-full flex justify-center mb-4 mt-1">
                    <span class="section-header inline-flex items-center justify-center w-full px-4 py-2 rounded-lg">
                        <h3 class="text-lg font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            Focus Area
                        </h3>
                    </span>
                </div>
                <div class="form-card rounded-2xl p-6">
                    <div class="text-sm font-semibold text-gray-800 mb-4">SDG Addressed</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @if($healthResearch->sdg_addressed)
                        @php
                        $sdgAddressed = is_string($healthResearch->sdg_addressed) ? explode(';', $healthResearch->sdg_addressed) : (array)$healthResearch->sdg_addressed;
                        @endphp
                        @foreach($sdgAddressed as $sdg)
                        @if(trim($sdg))
                        @php
                        $sdgModel = \App\Models\ref_sdgs::where('sdg_code', trim($sdg))->first();
                        @endphp
                        <div class="inline-flex items-center px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-lg">
                            <span class="text-gray-800 font-medium text-xs">{{ $sdgModel ? $sdgModel->sdg_desc : trim($sdg) }}</span>
                        </div>
                        @endif
                        @endforeach
                        @else
                        <div class="text-gray-500 italic">No SDG information available</div>
                        @endif
                    </div>
                </div>

                <!-- NUHRA Section -->
                <div class="w-full flex justify-center mb-4 mt-1">
                    <span class="section-header inline-flex items-center justify-center w-full px-4 py-2 rounded-lg">
                        <h3 class="text-lg font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            National Unified Health Research Agenda of the Philippines
                        </h3>
                    </span>
                </div>
                <div class="form-card rounded-2xl p-6">
                    <div class="text-sm font-semibold text-gray-800 mb-4">NUHRA</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @if($healthResearch->nuhra_addressed)
                        @php
                        $nuhraAddressed = is_string($healthResearch->nuhra_addressed) ? explode(';', $healthResearch->nuhra_addressed) : (array)$healthResearch->nuhra_addressed;
                        @endphp
                        @foreach($nuhraAddressed as $nuhra)
                        @if(trim($nuhra))
                        @if(trim($nuhra) === 'OTHERS')
                        <div class="inline-flex items-center px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-lg">
                            <span class="text-gray-800 font-medium text-xs">OTHERS: {{ $healthResearch->nuhra_others ?: 'Not specified' }}</span>
                        </div>
                        @else
                        @php
                        $nuhraModel = \App\Models\ref_nuhra::where('nuhra_code', trim($nuhra))->first();
                        @endphp
                        <div class="inline-flex items-center px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-lg">
                            <span class="text-gray-800 font-medium text-xs">{{ $nuhraModel ? $nuhraModel->nuhra_desc : trim($nuhra) }}</span>
                        </div>
                        @endif
                        @endif
                        @endforeach
                        @else
                        <div class="text-gray-500 italic">No NUHRA information available</div>
                        @endif
                    </div>
                </div>

                <!-- MTHRIA Section -->
                <div class="w-full flex justify-center mb-4 mt-1">
                    <span class="section-header inline-flex items-center justify-center w-full px-4 py-2 rounded-lg">
                        <h3 class="text-lg font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            Medium-Term Health Research and Innovation Agenda (MTHRIA)
                        </h3>
                    </span>
                </div>
                <div class="form-card rounded-2xl p-6">
                    <div class="text-sm font-semibold text-gray-800 mb-4">MTHRIA</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 pb-4">
                        @if($healthResearch->mthria_addressed)
                        @php
                        $mthriaAddressed = is_string($healthResearch->mthria_addressed) ? explode(';', $healthResearch->mthria_addressed) : (array)$healthResearch->mthria_addressed;
                        @endphp
                        @foreach($mthriaAddressed as $mthria)
                        @if(trim($mthria))
                        @if(trim($mthria) === 'OTHERS')
                        <div class="inline-flex items-center px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-lg">
                            <span class="text-gray-800 font-medium text-xs">OTHERS: {{ $healthResearch->mthria_others ?: 'Not specified' }}</span>
                        </div>
                        @else
                        @php
                        $mthriaModel = \App\Models\ref_mthria::where('mthria_code', trim($mthria))->first();
                        @endphp
                        <div class="inline-flex items-center px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-lg">
                            <span class="text-gray-800 font-medium text-xs">{{ $mthriaModel ? $mthriaModel->mthria_desc : trim($mthria) }}</span>
                        </div>
                        @endif
                        @endif
                        @endforeach
                        @else
                        <div class="text-gray-500 italic">No MTHRIA information available</div>
                        @endif
                    </div>
                </div>

                <!-- Innovation Section -->
                <div class="form-card rounded-2xl p-6">
                    <div class="text-sm font-semibold text-gray-800 mb-4">Innovation</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @if($healthResearch->agenda_addressed)
                        @php
                        $agendaAddressed = is_string($healthResearch->agenda_addressed) ? explode(';', $healthResearch->agenda_addressed) : (array)$healthResearch->agenda_addressed;
                        @endphp
                        @foreach($agendaAddressed as $agenda)
                        @if(trim($agenda))
                        @php
                        $agendaModel = \App\Models\ref_agenda::where('agenda_code', trim($agenda))->first();
                        @endphp
                        <div class="inline-flex items-center px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-lg">
                            <span class="text-gray-800 font-medium text-xs">{{ $agendaModel ? $agendaModel->agenda_desc : trim($agenda) }}</span>
                        </div>
                        @endif
                        @endforeach
                        @else
                        <div class="text-gray-500 italic">No Innovation information available</div>
                        @endif
                    </div>
                </div>

                <!-- SUBJECT Section -->
                <div class="w-full flex justify-center mb-4 mt-1">
                    <span class="section-header inline-flex items-center justify-center w-full px-4 py-2 rounded-lg">
                        <h3 class="text-lg font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            SUBJECT
                        </h3>
                    </span>
                </div>

                <div class="form-card rounded-2xl p-6 mb-6">
                    <div class="text-sm font-semibold text-gray-800 mb-3">MeSH Keywords</div>
                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium" style="min-height: 100px;">
                        @if($healthResearch->mesh_keywords)
                        @php
                        $meshKeywords = is_string($healthResearch->mesh_keywords) ? explode(';', $healthResearch->mesh_keywords) : (array)$healthResearch->mesh_keywords;
                        @endphp
                        <div class="flex flex-wrap gap-1">
                            @foreach($meshKeywords as $keyword)
                            @if(trim($keyword))
                            <span class="inline-flex items-center px-2 py-1 rounded-full border border-blue-300 text-blue-700 bg-white text-xs">{{ trim($keyword) }}</span>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <span class="text-gray-500 italic text-sm">No MeSH keywords available</span>
                        @endif
                    </div>
                </div>

                <div class="form-card rounded-2xl p-6 mb-6">
                    <div class="text-sm font-semibold text-gray-800 mb-3">Non-MeSH Keywords</div>
                    <div class="data-field block w-full rounded-lg px-3 py-2 text-sm font-medium" style="min-height: 100px;">
                        @if($healthResearch->non_mesh_keywords)
                        @php
                        $nonMeshKeywords = is_string($healthResearch->non_mesh_keywords) ? explode(';', $healthResearch->non_mesh_keywords) : (array)$healthResearch->non_mesh_keywords;
                        @endphp
                        <div class="flex flex-wrap gap-1">
                            @foreach($nonMeshKeywords as $keyword)
                            @if(trim($keyword))
                            <span class="inline-flex items-center px-2 py-1 rounded-full border border-blue-300 text-blue-700 bg-white text-xs">{{ trim($keyword) }}</span>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <span class="text-gray-500 italic text-sm">No Non-MeSH keywords available</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
