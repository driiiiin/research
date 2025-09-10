<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight tracking-tight">
                <span class="inline-flex items-center gap-2">
                    <svg class="w-7 h-7 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Add New Health Research') }}
                </span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-emerald-50" style="padding-top: 0px;">
        <div class="max-w-7xl mx-auto px-6">
            <style>
                /* Enhanced form styling */
                #health-research-form {
                    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.5);
                }

                /* Make all labels inside the form black and bold */
                #health-research-form label {
                    color: #1e293b !important;
                    font-weight: 600 !important;
                    font-size: 0.95rem;
                }

                /* Style injected asterisk spans */
                #health-research-form .form-asterisk {
                    color: #dc2626;
                    font-weight: 700;
                    font-size: 1.75em;
                    line-height: 1;
                    margin-left: 0.15em;
                    position: relative;
                    top: 0.3em;
                }

                /* Enhanced input styling */
                #health-research-form input[type="text"],
                #health-research-form input[type="email"],
                #health-research-form input[type="number"],
                #health-research-form input[type="url"],
                #health-research-form textarea,
                #health-research-form select {
                    background: #ffffff;
                    border: 2px solid #e2e8f0;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                }

                #health-research-form input[type="text"]:focus,
                #health-research-form input[type="email"]:focus,
                #health-research-form input[type="number"]:focus,
                #health-research-form input[type="url"]:focus,
                #health-research-form textarea:focus,
                #health-research-form select:focus {
                    border-color: #14532d;
                    box-shadow: 0 0 0 3px rgba(20, 83, 45, 0.1), 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    background: #ffffff;
                }

                /* Section header styling */
                .section-header {
                    background: linear-gradient(135deg, #14532d 0%, #14532d 100%);
                    box-shadow: 0 4px 14px 0 rgba(20, 83, 45, 0.3);
                }

                /* Card styling for form sections */
                .form-card {
                    background: #ffffff;
                    border: 1px solid #e2e8f0;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    transition: all 0.3s ease;
                }

                .form-card:hover {
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                }
                /* Main title color override */
                .bg-gradient-to-r.from-emerald-600.to-emerald-800.bg-clip-text.text-transparent {
                    background: none !important;
                    color: #14532d !important;
                    -webkit-background-clip: unset !important;
                    -webkit-text-fill-color: unset !important;
                }
            </style>
            <form id="health-research-form" method="POST" action="{{ route('research.health_researches.store') }}" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-2xl px-12 pb-12 space-y-12" data-next-accession-url="{{ route('research.health_researches.next_accession') }}">
                @csrf
                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-emerald-800 bg-clip-text text-transparent mb-2">Health Research Form</h2>
                    <!-- <p class="text-gray-600 text-lg">Create a new health research entry</p> -->
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const form = document.getElementById('health-research-form');
                        if (!form) return;
                        const labels = form.querySelectorAll('label');

                        labels.forEach(label => {
                            function wrapAsterisksInNode(node) {
                                if (node.nodeType === Node.TEXT_NODE) {
                                    const text = node.nodeValue;
                                    if (text && text.includes('*')) {
                                        const parts = text.split('*');
                                        const frag = document.createDocumentFragment();
                                        parts.forEach((part, index) => {
                                            if (part) frag.appendChild(document.createTextNode(part));
                                            if (index < parts.length - 1) {
                                                const span = document.createElement('span');
                                                span.className = 'form-asterisk';
                                                span.textContent = '*';
                                                frag.appendChild(span);
                                            }
                                        });
                                        node.parentNode.replaceChild(frag, node);
                                    }
                                } else if (node.nodeType === Node.ELEMENT_NODE) {
                                    // Avoid descending into inputs/selects/textareas
                                    if (["INPUT", "SELECT", "TEXTAREA"].includes(node.tagName)) return;
                                    Array.from(node.childNodes).forEach(wrapAsterisksInNode);
                                }
                            }
                            Array.from(label.childNodes).forEach(wrapAsterisksInNode);
                        });

                        // Ensure Research Title has a red asterisk (required)
                        const rtLabel = form.querySelector('label[for="research_title"]');
                        if (rtLabel) {
                            const hasAsterisk = rtLabel.querySelector('.form-asterisk') || /\*/.test(rtLabel.textContent);
                            if (!hasAsterisk) {
                                const star = document.createElement('span');
                                star.className = 'form-asterisk';
                                star.textContent = '*';
                                rtLabel.appendChild(star);
                            }
                        }
                    });
                </script>

                <div class="space-y-8">
                    <!-- Title Section -->
                    <div class="w-full flex justify-center mb-6 mt-2">
                        <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                            <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                TITLE
                            </h3>
                        </span>
                    </div>
                    <div class="form-card rounded-2xl p-8">
                        <div class="flex flex-col lg:flex-row lg:items-end gap-6">
                            <div class="flex-shrink-0" style="display: inline-block; min-width: 220px; max-width: 100%;">
                                <x-input-label for="accession_no" value="Accession No." class="text-base font-semibold text-gray-800 mb-2" />
                                <input
                                    type="text"
                                    name="accession_no"
                                    id="accession_no"
                                    class="block w-full rounded-xl px-4 py-3 text-base font-medium"
                                    style="height:48px; min-height:48px; max-width:350px;"
                                    placeholder="Loading..."
                                    value=""
                                    readonly
                                    required>
                            </div>
                            <div class="flex-1">
                                <x-input-label for="research_title" value="Research Title" class="text-lg font-semibold text-gray-800 mb-2" />
                                <textarea name="research_title" id="research_title"
                                    class="block w-full rounded-xl px-4 py-3 text-lg font-medium resize-y"
                                    maxlength="500"
                                    style="height:48px; min-height:48px; max-height:180px;"
                                    placeholder="Enter research title (up to 500 characters)">{{ old('research_title') }}</textarea>
                            </div>
                        </div>
                        <div class="mt-6">
                            <x-input-label value="Subtitle" class="text-lg font-semibold text-gray-800 mb-2" />
                            <textarea name="subtitle" id="subtitle"
                                class="block w-full rounded-xl px-4 py-3 text-lg font-medium resize-y"
                                maxlength="500"
                                style="height:48px; min-height:48px; max-height:180px;"
                                placeholder="Enter research subtitle (up to 500 characters)">{{ old('subtitle') }}</textarea>
                        </div>
                    </div>
                    <!-- Source Section -->
                    <div class="w-full flex justify-center mb-6 mt-2">
                        <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                            <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                SOURCE
                            </h3>
                        </span>
                    </div>

                    <!-- Date Issued -->
                    <div class="form-card rounded-2xl p-8">
                        <x-input-label value="Date Issued *" class="text-lg font-semibold text-gray-800 mb-4" />
                        <div
                            x-data="{
                                mode: '{{ old('date_issued_mode', 'month_year') }}',
                                fromMonth: '{{ old('date_issued_from_month') }}',
                                fromYear: '{{ old('date_issued_from_year') }}',
                                toMonth: '{{ old('date_issued_to_month') }}',
                                toYear: '{{ old('date_issued_to_year') }}',
                                months: [
                                    {num: 1, name: 'Jan'}, {num: 2, name: 'Feb'}, {num: 3, name: 'Mar'}, {num: 4, name: 'Apr'},
                                    {num: 5, name: 'May'}, {num: 6, name: 'Jun'}, {num: 7, name: 'Jul'}, {num: 8, name: 'Aug'},
                                    {num: 9, name: 'Sep'}, {num: 10, name: 'Oct'}, {num: 11, name: 'Nov'}, {num: 12, name: 'Dec'}
                                ],
                                yearPattern: /^[0-9]{4}$/,
                                validateYear(val) {
                                    return this.yearPattern.test(val);
                                }
                            }"
                            class="flex flex-col gap-4">
                            <div class="flex gap-6 items-center mb-2">
                                <label class="inline-flex items-center px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-lg cursor-pointer transition hover:bg-emerald-100">
                                    <input type="radio" name="date_issued_mode" value="month_year" x-model="mode" class="form-radio text-emerald-600 focus:ring-emerald-500" checked>
                                    <span class="ml-3 text-gray-700 font-medium">Month & Year</span>
                                </label>
                                <label class="inline-flex items-center px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-lg cursor-pointer transition hover:bg-emerald-100">
                                    <input type="radio" name="date_issued_mode" value="year_only" x-model="mode" class="form-radio text-emerald-600 focus:ring-emerald-500">
                                    <span class="ml-3 text-gray-700 font-medium">Year Only</span>
                                </label>
                            </div>
                            <div class="flex flex-wrap gap-4 mt-2">
                                <template x-if="mode === 'month_year'">
                                    <div class="flex flex-wrap gap-4 w-full items-end">
                                        <div class="flex-1 min-w-[120px]">
                                            <x-input-label for="date_issued_from_month" value="From Month" class="text-sm font-medium text-gray-700 mb-1" />
                                            <select id="date_issued_from_month" name="date_issued_from_month" class="block w-full rounded-xl px-4 py-3 font-medium"
                                                x-model="fromMonth" required>
                                                <option value="">Select Month</option>
                                                <template x-for="m in months" :key="m.num">
                                                    <option :value="m.num" x-text="m.name" :selected="fromMonth == m.num"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div class="flex-1 min-w-[100px]">
                                            <x-input-label for="date_issued_from_year" value="From Year" class="text-sm font-medium text-gray-700 mb-1" />
                                            <input
                                                type="text"
                                                id="date_issued_from_year"
                                                name="date_issued_from_year"
                                                class="block w-full rounded-xl px-4 py-3 font-medium"
                                                x-model="fromYear"
                                                maxlength="4"
                                                pattern="[0-9]{4}"
                                                placeholder="YYYY"
                                                required
                                                @input="if (!validateYear($event.target.value) && $event.target.value.length > 0) { $event.target.setCustomValidity('Please enter a valid 4-digit year'); } else { $event.target.setCustomValidity(''); }" />
                                        </div>
                                        <span class="self-center px-3 py-2 text-gray-500 font-medium">to</span>
                                        <div class="flex-1 min-w-[120px]">
                                            <x-input-label for="date_issued_to_month" value="To Month" class="text-sm font-medium text-gray-700 mb-1" />
                                            <select id="date_issued_to_month" name="date_issued_to_month" class="block w-full rounded-xl px-4 py-3 font-medium"
                                                x-model="toMonth" required>
                                                <option value="">Select Month</option>
                                                <template x-for="m in months" :key="m.num">
                                                    <option :value="m.num" x-text="m.name" :selected="toMonth == m.num"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div class="flex-1 min-w-[100px]">
                                            <x-input-label for="date_issued_to_year" value="To Year" class="text-sm font-medium text-gray-700 mb-1" />
                                            <input
                                                type="text"
                                                id="date_issued_to_year"
                                                name="date_issued_to_year"
                                                class="block w-full rounded-xl px-4 py-3 font-medium"
                                                x-model="toYear"
                                                maxlength="4"
                                                pattern="[0-9]{4}"
                                                placeholder="YYYY"
                                                required
                                                @input="if (!validateYear($event.target.value) && $event.target.value.length > 0) { $event.target.setCustomValidity('Please enter a valid 4-digit year'); } else { $event.target.setCustomValidity(''); }" />
                                        </div>
                                    </div>
                                </template>
                                <template x-if="mode === 'year_only'">
                                    <div class="flex flex-wrap gap-4">
                                        <div class="flex-1 min-w-[200px]">
                                            <x-input-label for="date_issued_from_year" value="Year" class="text-sm font-medium text-gray-700 mb-1" />
                                            <input
                                                type="text"
                                                id="date_issued_from_year"
                                                name="date_issued_from_year"
                                                class="block w-full rounded-xl px-4 py-3 font-medium"
                                                x-model="fromYear"
                                                maxlength="4"
                                                pattern="[0-9]{4}"
                                                placeholder="YYYY"
                                                required
                                                @input="if (!validateYear($event.target.value) && $event.target.value.length > 0) { $event.target.setCustomValidity('Please enter a valid 4-digit year'); } else { $event.target.setCustomValidity(''); }" />
                                        </div>
                                        <!-- Hide month fields and to year when in year-only mode -->
                                        <input type="hidden" name="date_issued_from_month" value="">
                                        <input type="hidden" name="date_issued_to_month" value="">
                                        <input type="hidden" name="date_issued_to_year" value="">
                                    </div>
                                </template>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('date_issued_from_month')" class="mt-2" />
                        <x-input-error :messages="$errors->get('date_issued_from_year')" class="mt-2" />
                        <x-input-error :messages="$errors->get('date_issued_to_month')" class="mt-2" />
                        <x-input-error :messages="$errors->get('date_issued_to_year')" class="mt-2" />
                    </div>

                    <!-- Publication Details -->
                    <div class="form-card rounded-2xl p-8">
                        <x-input-label value="Publication Details" class="text-lg font-semibold text-gray-800 mb-6" />
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="volume_no" value="Volume No." class="text-sm font-medium text-gray-700 mb-2" />
                                <input id="volume_no" name="volume_no" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('volume_no') }}"/>
                                <x-input-error :messages="$errors->get('volume_no')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="issue_no" value="Issue No." class="text-sm font-medium text-gray-700 mb-2" />
                                <input id="issue_no" name="issue_no" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('issue_no') }}" />
                                <x-input-error :messages="$errors->get('issue_no')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="pages" value="Page(s)" class="text-sm font-medium text-gray-700 mb-2" />
                                <input id="pages" name="pages" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('pages') }}" />
                                <x-input-error :messages="$errors->get('pages')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="article_no" value="Article No." class="text-sm font-medium text-gray-700 mb-2" />
                                <input id="article_no" name="article_no" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('article_no') }}" />
                                <x-input-error :messages="$errors->get('article_no')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="doi" value="DOI" class="text-sm font-medium text-gray-700 mb-2" />
                                <input id="doi" name="doi" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('doi') }}" />
                                <x-input-error :messages="$errors->get('doi')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="implementing_agency" value="Implementing Agency" class="text-sm font-medium text-gray-700 mb-2" />
                                <input type="text" name="implementing_agency" id="implementing_agency" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('implementing_agency') }}">
                            </div>
                            <div>
                                <x-input-label for="cooperating_agency" value="Cooperating Agency" class="text-sm font-medium text-gray-700 mb-2" />
                                <input type="text" name="cooperating_agency" id="cooperating_agency" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('cooperating_agency') }}">
                            </div>
                            <div
                                x-data="{
                                    isGovFund: '{{ old('is_gov_fund', '') }}' === 'yes',
                                    raw: '{{ old('budget') }}',
                                    get formatted() {
                                        if (this.raw === '' || isNaN(this.raw)) return '';
                                        return Number(this.raw).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                    }
                                }"
                                class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2 mb-2">
                                    <x-input-label value="Is this research funded by the government?" class="text-sm font-medium text-gray-700 mb-2" />
                                    <div class="flex gap-6 mt-1">
                                        <label class="inline-flex items-center">
                                            <input
                                                type="radio"
                                                name="is_gov_fund"
                                                value="yes"
                                                x-model="isGovFund"
                                                :checked="'{{ old('is_gov_fund') }}' === 'yes'"
                                                @change="isGovFund = true"
                                                class="form-radio text-emerald-600 focus:ring-emerald-500">
                                            <span class="ml-2 text-gray-800">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input
                                                type="radio"
                                                name="is_gov_fund"
                                                value="no"
                                                x-model="isGovFund"
                                                :checked="'{{ old('is_gov_fund') }}' === 'no'"
                                                @change="isGovFund = false"
                                                class="form-radio text-emerald-600 focus:ring-emerald-500">
                                            <span class="ml-2 text-gray-800">No</span>
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('is_gov_fund')" class="mt-2" />
                                </div>
                                <template x-if="isGovFund">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:col-span-2">
                                        <div class="relative">
                                            <label for="budget" class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                                                Research Budget
                                                <span class="form-asterisk">*</span>
                                            </label>
                                            <input
                                                type="number"
                                                class="block w-full rounded-xl px-4 py-3 font-medium"
                                                id="budget"
                                                name="budget"
                                                step="0.01"
                                                min="0"
                                                x-model="raw"
                                                @input="raw = $event.target.value"
                                                value="{{ old('budget') }}"
                                                required>
                                            <template x-if="formatted">
                                                <div class="text-emerald-600 font-semibold mt-2 text-sm select-none">
                                                    <span x-text="formatted"></span>
                                                </div>
                                            </template>
                                            <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                                        </div>
                                        <div>
                                            <label for="currency_code" class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                                                Currency
                                                <span class="form-asterisk">*</span>
                                            </label>
                                            <select
                                                id="currency_code"
                                                name="currency_code"
                                                class="block w-full rounded-xl px-4 py-3 font-medium"
                                                required>
                                                <option value="">Select currency</option>
                                                @php
                                                $currencies = \DB::table('ref_currency')->orderBy('currency_desc')->get();
                                                @endphp
                                                @foreach($currencies as $currency)
                                                <option value="{{ $currency->currency_code }}" {{ old('currency_code') == $currency->currency_code ? 'selected' : '' }}>
                                                    {{ $currency->currency_desc }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('currency_code')" class="mt-2" />
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div>
                                <x-input-label for="funding_agency" value="Funding Agency" class="text-sm font-medium text-gray-700 mb-2" />
                                <input type="text" name="funding_agency" id="funding_agency" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('funding_agency') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="form-card rounded-2xl p-8">
                        <x-input-label for="notes" value="General Notes" class="text-lg font-semibold text-gray-800 mb-4" />
                        <textarea
                            id="notes"
                            name="notes"
                            rows="4"
                            class="block w-full rounded-xl px-4 py-3 font-medium resize-y"
                            placeholder="Enter any additional notes here...">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <!-- Research Category -->
                    <div class="form-card rounded-2xl p-8">
                        <x-input-label value="Research Category *" class="text-lg font-semibold text-gray-800 mb-4" />
                        <div class="flex flex-wrap gap-4">
                            <label class="inline-flex items-center px-4 py-3 bg-orange-50 border border-orange-200 rounded-xl cursor-pointer transition hover:bg-orange-100">
                                <input type="radio" name="research_category" value="Institutional" {{ old('research_category') == 'Institutional' ? 'checked' : '' }} required class="form-radio text-orange-600 focus:ring-orange-500" x-ref="research_category" />
                                <span class="ml-3 text-gray-700 font-medium">Institutional</span>
                            </label>
                            <label class="inline-flex items-center px-4 py-3 bg-orange-50 border border-orange-200 rounded-xl cursor-pointer transition hover:bg-orange-100">
                                <input type="radio" name="research_category" value="Collaborative" {{ old('research_category') == 'Collaborative' ? 'checked' : '' }} required class="form-radio text-orange-600 focus:ring-orange-500" x-ref="research_category" />
                                <span class="ml-3 text-gray-700 font-medium">Collaborative</span>
                            </label>
                            <label class="inline-flex items-center px-4 py-3 bg-orange-50 border border-orange-200 rounded-xl cursor-pointer transition hover:bg-orange-100">
                                <input type="radio" name="research_category" value="Commissioned" {{ old('research_category') == 'Commissioned' ? 'checked' : '' }} required class="form-radio text-orange-600 focus:ring-orange-500" x-ref="research_category" />
                                <span class="ml-3 text-gray-700 font-medium">Commissioned</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('research_category')" class="mt-2" />
                    </div>

                    <!-- Research Type -->
                    <div class="form-card rounded-2xl p-8">
                        <x-input-label value="Research Type *" class="text-lg font-semibold text-gray-800 mb-4" />
                        <div class="flex flex-wrap gap-4">
                            <label class="inline-flex items-center px-4 py-3 bg-orange-50 border border-orange-200 rounded-xl cursor-pointer transition hover:bg-orange-100">
                                <input type="radio" name="research_type" value="Basic" {{ old('research_type') == 'Basic' ? 'checked' : '' }} required class="form-radio text-orange-600 focus:ring-orange-500" x-ref="research_type" />
                                <span class="ml-3 text-gray-700 font-medium">Basic</span>
                            </label>
                            <label class="inline-flex items-center px-4 py-3 bg-orange-50 border border-orange-200 rounded-xl cursor-pointer transition hover:bg-orange-100">
                                <input type="radio" name="research_type" value="Applied" {{ old('research_type') == 'Applied' ? 'checked' : '' }} required class="form-radio text-orange-600 focus:ring-orange-500" x-ref="research_type" />
                                <span class="ml-3 text-gray-700 font-medium">Applied</span>
                            </label>
                            <label class="inline-flex items-center px-4 py-3 bg-orange-50 border border-orange-200 rounded-xl cursor-pointer transition hover:bg-orange-100">
                                <input type="radio" name="research_type" value="Experimental" {{ old('research_type') == 'Experimental' ? 'checked' : '' }} required class="form-radio text-orange-600 focus:ring-orange-500" x-ref="research_type" />
                                <span class="ml-3 text-gray-700 font-medium">Experimental</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('research_type')" class="mt-2" />
                    </div>

                    <!-- Author Details Section -->
                    <div class="w-full flex justify-center mb-6 mt-2">
                        <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                            <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                AUTHOR
                            </h3>
                        </span>
                    </div>

                    <div x-data="{
                            authorForms: [0],
                            addAuthorForm() {
                                this.authorForms.push(this.authorForms.length);
                            },
                            removeAuthorForm(index) {
                                if (this.authorForms.length > 1) {
                                    this.authorForms.splice(index, 1);
                                }
                            }
                        }" class="space-y-6 -mt-4">
                        <template x-for="(formIndex, index) in authorForms" :key="formIndex">
                            <div class="form-card rounded-2xl p-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                    <div>
                                        <x-input-label for="author_last_name" value="Last Name" class="text-sm font-medium text-gray-700 mb-2" />
                                        <input id="author_last_name" name="author_last_name[]" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" placeholder="Enter last name" />
                                        <x-input-error :messages="$errors->get('author_last_name.*')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="author_first_name" value="First Name" class="text-sm font-medium text-gray-700 mb-2" />
                                        <input id="author_first_name" name="author_first_name[]" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" placeholder="Enter first name" />
                                        <x-input-error :messages="$errors->get('author_first_name.*')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="author_middle_name" value="Middle Name" class="text-sm font-medium text-gray-700 mb-2" />
                                        <input id="author_middle_name" name="author_middle_name[]" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" placeholder="Enter middle name" />
                                        <x-input-error :messages="$errors->get('author_middle_name.*')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="author_suffix" value="Suffix" class="text-sm font-medium text-gray-700 mb-2" />
                                        <select id="author_suffix" name="author_suffix[]" class="block w-full rounded-xl px-4 py-3 font-medium">
                                            <option value="">-- Select --</option>
                                            <option value="Jr.">Jr.</option>
                                            <option value="Sr.">Sr.</option>
                                            <option value="I">I</option>
                                            <option value="II">II</option>
                                            <option value="III">III</option>
                                            <option value="IV">IV</option>
                                            <option value="V">V</option>
                                            <option value="Ph.D.">Ph.D.</option>
                                            <option value="M.D.">M.D.</option>
                                            <option value="M.Sc.">M.Sc.</option>
                                            <option value="B.Sc.">B.Sc.</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('author_suffix.*')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="flex justify-end mt-6">
                                    <button
                                        type="button"
                                        @click="removeAuthorForm(index)"
                                        x-show="authorForms.length > 1"
                                        class="w-8 h-8 bg-red-500 text-white rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 flex items-center justify-center transition-all duration-200 shadow-md hover:shadow-lg"
                                        title="Remove Author">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <div class="flex justify-end mt-6">
                            <button type="button" @click="addAuthorForm()" class="w-10 h-10 bg-orange-500 text-white rounded-full hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 flex items-center justify-center transition-all duration-200 shadow-md hover:shadow-lg" title="Add Author">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Abstract Section -->
                    <div class="w-full flex justify-center mb-6 mt-2">
                        <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                            <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                ABSTRACT
                            </h3>
                        </span>
                    </div>

                    <div class="form-card rounded-2xl p-8">
                        <div class="mb-6">
                            <x-input-label for="abstract_type" value="Abstract Type" class="text-sm font-medium text-gray-700 mb-2" />
                            <select id="abstract_type" name="abstract_type" class="block w-full rounded-xl px-4 py-3 font-medium">
                                <option value="Full Abstract" selected>Full Abstract</option>
                            </select>
                            <x-input-error :messages="$errors->get('abstract_type')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="research_abstract" value="Abstract Content" class="text-sm font-medium text-gray-700 mb-2" />
                            <textarea id="research_abstract" name="research_abstract" rows="8" class="block w-full rounded-xl px-4 py-3 font-medium resize-y" placeholder="Enter your research abstract here...">{{ old('research_abstract') }}</textarea>
                            <x-input-error :messages="$errors->get('research_abstract')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Reference Section -->
                    <div class="w-full flex justify-center mb-6 mt-2">
                        <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                            <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                REFERENCE / CITATION
                            </h3>
                        </span>
                    </div>

                    <div class="form-card rounded-2xl p-8">
                        <x-input-label for="reference" value="Reference / Citation" class="text-lg font-semibold text-gray-800 mb-4" />
                        <textarea id="reference" name="reference" rows="6" class="block w-full rounded-xl px-4 py-3 font-medium resize-y" placeholder="Enter your references here...">{{ old('reference') }}</textarea>
                        <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                    </div>

                    <!-- Location Section -->
                    <div class="w-full flex justify-center mb-6 mt-2">
                        <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                            <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                LOCATION
                            </h3>
                        </span>
                    </div>

                    <div x-data="{
                        locationForms: [{id: 0, format: '', mode_of_access: ''}],
                        addLocationForm() {
                            this.locationForms.push({id: this.locationForms.length, format: '', mode_of_access: ''});
                        },
                        removeLocationForm(index) {
                            if (this.locationForms.length > 1) {
                                this.locationForms.splice(index, 1);
                            }
                        }
                    }" class="space-y-6 -mt-4">

                        <!-- LOCATION Forms Container -->
                        <template x-for="(form, index) in locationForms" :key="form.id">
                            <div class="form-card rounded-2xl p-8">
                                <div class="flex justify-end mb-6">
                                    <button
                                        type="button"
                                        @click="removeLocationForm(index)"
                                        x-show="locationForms.length > 1"
                                        class="w-8 h-8 bg-red-500 text-white rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 flex items-center justify-center transition-all duration-200 shadow-md hover:shadow-lg"
                                        title="Remove Location">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-gray-600 italic mb-6 text-sm">Please input the location where the material can be viewed or accessed.</p>

                                <!-- Format Selection -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <x-input-label for="format" value="Format *" class="text-sm font-medium text-gray-700 mb-2" />
                                        <select id="format" name="format[]" x-model="form.format" x-ref="format" class="block w-full rounded-xl px-4 py-3 font-medium" required>
                                            <option value="">Select Format</option>
                                            <option value="Print">Print</option>
                                            <option value="Non-Print">Non-Print</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('format.*')" class="mt-2" />
                                    </div>
                                </div>
                                <!-- Print Format Fields -->
                                <div x-show="form.format === 'Print'">
                                    <!-- Physical Location -->
                                    <div class="mb-6">
                                        <x-input-label for="physical_location_print" value="Physical Location" />
                                        <x-text-input id="physical_location_print" name="physical_location[]" x-ref="physical_location" type="text" class="mt-1 block w-full" value="{{ is_array(old('physical_location.0')) ? '' : old('physical_location.0') }}" placeholder="Location" />
                                        <x-input-error :messages="$errors->get('physical_location.*')" class="mt-2" />
                                    </div>

                                    <!-- Location Number -->
                                    <div class="mb-6">
                                        <div>
                                            <x-input-label for="location_number_print" value="Location Number" />
                                            <x-text-input id="location_number_print" name="location_number[]" type="text" class="mt-1 block w-full" value="{{ is_array(old('location_number.0')) ? '' : old('location_number.0') }}" />
                                            <x-input-error :messages="$errors->get('location_number.*')" class="mt-2" />
                                        </div>
                                    </div>

                                    <!-- Text Availability, Mode of Access, and Status -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                        <div class="flex flex-col">
                                            <x-input-label for="text_availability_print" value="Text Availability *" class="text-sm font-medium text-gray-700 mb-2" />
                                            <select id="text_availability_print" name="text_availability[]" x-ref="text_availability" class="block w-full rounded-xl px-4 py-3 font-medium" x-bind:required="form.format === 'Print'">
                                                <option value="">Select Text Availability</option>
                                                <option value="Abstract Only" {{ (is_array(old('text_availability.0')) ? '' : old('text_availability.0')) == 'Abstract Only' ? 'selected' : '' }}>Abstract Only</option>
                                                <option value="Full-text" {{ (is_array(old('text_availability.0')) ? '' : old('text_availability.0')) == 'Full-text' ? 'selected' : '' }}>Full-text</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('text_availability.*')" class="mt-2" />
                                        </div>
                                        <div class="flex flex-col">
                                            <x-input-label for="mode_of_access_print" value="Mode of Access *" class="text-sm font-medium text-gray-700 mb-2" />
                                            <select id="mode_of_access_print" name="mode_of_access[]" x-model="form.mode_of_access" x-ref="mode_of_access" class="block w-full rounded-xl px-4 py-3 font-medium" x-bind:required="form.format === 'Print'">
                                                <option value="">Select Mode of Access</option>
                                                <option value="Request to Institution" {{ (is_array(old('mode_of_access.0')) ? '' : old('mode_of_access.0')) == 'Request to Institution' ? 'selected' : '' }}>Request to Institution</option>
                                                <option value="Room use Only" {{ (is_array(old('mode_of_access.0')) ? '' : old('mode_of_access.0')) == 'Room use Only' ? 'selected' : '' }}>Room use Only</option>
                                                <option value="Not available to the public" {{ (is_array(old('mode_of_access.0')) ? '' : old('mode_of_access.0')) == 'Not available to the public' ? 'selected' : '' }}>Not available to the public</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('mode_of_access.*')" class="mt-2" />
                                        </div>
                                        <div class="flex flex-col">
                                            <x-input-label for="status_print" value="Status" class="text-sm font-medium text-gray-700 mb-2" />
                                            <select name="status[]" id="status_print" class="block w-full rounded-xl px-4 py-3 font-medium">
                                                <option value="">Select Status</option>
                                                <option value="Ongoing" {{ (is_array(old('status.0')) ? '' : old('status.0')) == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                                <option value="Completed" {{ (is_array(old('status.0')) ? '' : old('status.0')) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('status.*')" class="mt-2" />
                                        </div>
                                    </div>

                                    <!-- Institutional Email (conditional) -->
                                    <div x-show="form.mode_of_access === 'Request to Institution'" class="mb-6">
                                        <div>
                                            <x-input-label for="institutional_email_print" value="Institutional Email *" />
                                            <x-text-input id="institutional_email_print" name="institutional_email[]" type="email" class="mt-1 block w-full" value="{{ is_array(old('institutional_email.0')) ? '' : old('institutional_email.0') }}" placeholder="Institution Email" x-bind:required="form.mode_of_access === 'Request to Institution'" />
                                            <x-input-error :messages="$errors->get('institutional_email.*')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Non-Print Format Fields -->
                                <div x-show="form.format === 'Non-Print'">
                                    <!-- Location -->
                                    <div class="mb-6">
                                        <x-input-label for="physical_location_nonprint" value="Location *" />
                                        <x-text-input id="physical_location_nonprint" name="physical_location[]" x-ref="physical_location" type="text" class="mt-1 block w-full" value="{{ is_array(old('physical_location.0')) ? '' : old('physical_location.0') }}" placeholder="Location" x-bind:required="form.format === 'Non-Print'" />
                                        <x-input-error :messages="$errors->get('physical_location.*')" class="mt-2" />
                                    </div>

                                    <!-- Choice Section for Non-Print -->
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                        <h4 class="text-sm font-medium text-blue-900 mb-3">Please tick any of the two choices:</h4>
                                        <div class="space-y-3">
                                            <div class="flex items-center space-x-3">
                                                <input type="checkbox" id="enter_url_nonprint" name="enter_url[]" value="1" {{ (is_array(old('enter_url.0')) ? '' : old('enter_url.0')) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <label for="enter_url_nonprint" class="text-sm text-blue-900">Enter URL</label>
                                                <input type="url" name="url[]" id="url_input_nonprint" class="flex-1 ml-2 text-sm text-gray-500 border border-gray-300 rounded px-3 py-2" value="{{ is_array(old('url.0')) ? '' : old('url.0') }}" placeholder="https://example.com" disabled />
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <input type="checkbox" id="upload_file_nonprint" name="upload_file[]" value="1" {{ (is_array(old('upload_file.0')) ? '' : old('upload_file.0')) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <label for="upload_file_nonprint" class="text-sm text-blue-900">Upload File</label>
                                                <input type="file" name="file[]" id="file_upload_nonprint" class="flex-1 ml-2 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" disabled />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text Availability, Mode of Access, and Status for Non-Print -->
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                        <div class="flex flex-col">
                                            <x-input-label for="text_availability_nonprint" value="Text Availability *" class="text-sm font-medium text-gray-700 mb-2" />
                                            <select id="text_availability_nonprint" name="text_availability[]" x-ref="text_availability" class="block w-full rounded-xl px-4 py-3 font-medium" x-bind:required="form.format === 'Non-Print'">
                                                <option value="">Select Text Availability</option>
                                                <option value="Abstract Only" {{ (is_array(old('text_availability.0')) ? '' : old('text_availability.0')) == 'Abstract Only' ? 'selected' : '' }}>Abstract Only</option>
                                                <option value="Full-text" {{ (is_array(old('text_availability.0')) ? '' : old('text_availability.0')) == 'Full-text' ? 'selected' : '' }}>Full-text</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('text_availability.*')" class="mt-2" />
                                        </div>
                                        <div class="flex flex-col">
                                            <x-input-label for="mode_of_access_nonprint" value="Mode of Access *" class="text-sm font-medium text-gray-700 mb-2" />
                                            <select id="mode_of_access_nonprint" name="mode_of_access[]" x-ref="mode_of_access" class="block w-full rounded-xl px-4 py-3 font-medium" x-bind:required="form.format === 'Non-Print'">
                                                <option value="">Select Mode of Access</option>
                                                <option value="Online Request" {{ (is_array(old('mode_of_access.0')) ? '' : old('mode_of_access.0')) === 'Online Request' ? 'selected' : '' }}>Online Request</option>
                                                <option value="Publicly accessible" {{ (is_array(old('mode_of_access.0')) ? '' : old('mode_of_access.0')) === 'Publicly accessible' ? 'selected' : '' }}>Publicly accessible</option>
                                                <option value="Not available to the public" {{ (is_array(old('mode_of_access.0')) ? '' : old('mode_of_access.0')) === 'Not available to the public' ? 'selected' : '' }}>Not available to the public</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('mode_of_access.*')" class="mt-2" />
                                        </div>
                                        <div class="flex flex-col">
                                            <x-input-label for="status_nonprint" value="Status" class="text-sm font-medium text-gray-700 mb-2" />
                                            <select name="status[]" id="status_nonprint" class="block w-full rounded-xl px-4 py-3 font-medium">
                                                <option value="">Select Status</option>
                                                <option value="Ongoing" {{ (is_array(old('status.0')) ? '' : old('status.0')) == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                                <option value="Completed" {{ (is_array(old('status.0')) ? '' : old('status.0')) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('status.*')" class="mt-2" />
                                        </div>
                                    </div>
                                    <p id="nonprint-upload-url-error" class="text-red-600 text-sm hidden">Please select at least Enter URL or Upload File for Non-Print.</p>
                                </div>
                            </div>
                    </div>
                    </template>
                    <div class="flex justify-end mt-6">
                        <button type="button" @click="addLocationForm()" class="w-10 h-10 bg-orange-500 text-white rounded-full hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 flex items-center justify-center transition-all duration-200 shadow-md hover:shadow-lg" title="Add Location">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- SDG Section (Required, Multiple) -->
                <div class="w-full flex justify-center mb-6 mt-2">
                    <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                        <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            Focus Area
                        </h3>
                    </span>
                </div>
                <div class="form-card rounded-2xl p-8">
                    <x-input-label class="text-lg font-semibold text-gray-800 mb-6">
                        SDG Addressed <span class="text-red-500">* (You may select more than one SDG.)</span>
                    </x-input-label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach(\App\Models\ref_sdgs::all() as $sdg)
                        <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm cursor-pointer transition hover:bg-emerald-100 hover:shadow-md">
                            <input
                                type="checkbox"
                                name="sdg_addressed[]"
                                value="{{ $sdg->sdg_code }}"
                                class="form-checkbox text-emerald-600 focus:ring-emerald-500 rounded"
                                {{ (collect(old('sdg_addressed'))->contains($sdg->sdg_code)) ? 'checked' : '' }}
                            >
                            <span class="ml-3 text-gray-800 font-medium text-sm">{{ $sdg->sdg_desc }}</span>
                        </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('sdg_addressed')" class="mt-2" />

                </div>
                <!-- Nuhra Section -->
                <div class="w-full flex justify-center mb-6 mt-2">
                    <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                        <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            National Unified Health Research Agenda of the Philippines
                        </h3>
                    </span>
                </div>
                <div class="form-card rounded-2xl p-8">
                    <x-input-label class="text-lg font-semibold text-gray-800 mb-6">
                        NUHRA <span class="text-red-500">* (You may select more than one NUHRA.)</span>
                    </x-input-label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach(\App\Models\ref_nuhra::all() as $nuhra)
                        <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm cursor-pointer transition hover:bg-emerald-100 hover:shadow-md">
                            <input
                                type="checkbox"
                                name="nuhra_addressed[]"
                                value="{{ $nuhra->nuhra_code }}"
                                class="form-checkbox text-emerald-600 focus:ring-emerald-500 rounded"
                                {{ (collect(old('nuhra_addressed'))->contains($nuhra->nuhra_code)) ? 'checked' : '' }}
                            >
                            <span class="ml-3 text-gray-800 font-medium text-sm">{{ $nuhra->nuhra_desc }}</span>
                        </label>
                        @endforeach
                        <!-- OTHERS option for NUHRA -->
                        <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm cursor-pointer transition hover:bg-emerald-100 hover:shadow-md">
                            <input
                                type="checkbox"
                                name="nuhra_addressed[]"
                                value="OTHERS"
                                class="form-checkbox text-emerald-600 focus:ring-emerald-500 rounded"
                                id="nuhra_others_checkbox"
                                @if(is_array(old('nuhra_addressed')) && in_array('OTHERS', old('nuhra_addressed'))) checked @endif
                            >
                            <span class="ml-3 text-gray-800 font-medium text-sm">OTHERS</span>
                        </label>
                        <input
                            type="text"
                            name="nuhra_others"
                            id="nuhra_others_input"
                            class="mt-2 block w-full rounded-xl px-4 py-3 font-medium border border-gray-300"
                            placeholder="Please specify other NUHRA"
                            style="display: none;"
                            value="{{ old('nuhra_others') }}"
                        >
                    </div>
                    <x-input-error :messages="$errors->get('nuhra_addressed')" class="mt-2" />
                </div>
                <!-- MTHRIA Section -->
                <div class="w-full flex justify-center mb-6 mt-2">
                    <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                        <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                            Medium-Term Health Research and Innovation Agenda (MTHRIA)
                        </h3>
                    </span>
                </div>
                <div class="form-card rounded-2xl p-8">
                    <x-input-label class="text-lg font-semibold text-gray-800 mb-6">
                        MTHRIA <span class="text-red-500">* (You may select more than one MTHRIA.)</span>
                    </x-input-label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pb-4">
                        @foreach(\App\Models\ref_mthria::all() as $mthria)
                        <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm cursor-pointer transition hover:bg-emerald-100 hover:shadow-md">
                            <input
                                type="checkbox"
                                name="mthria_addressed[]"
                                value="{{ $mthria->mthria_code }}"
                                class="form-checkbox text-emerald-600 focus:ring-emerald-500 rounded"
                                {{ (collect(old('mthria_addressed'))->contains($mthria->mthria_code)) ? 'checked' : '' }}
                            >
                            <span class="ml-3 text-gray-800 font-medium text-sm">{{ $mthria->mthria_desc }}</span>
                        </label>
                        @endforeach
                        <!-- OTHERS option for MTHRIA -->
                        <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm cursor-pointer transition hover:bg-emerald-100 hover:shadow-md">
                            <input
                                type="checkbox"
                                name="mthria_addressed[]"
                                value="OTHERS"
                                class="form-checkbox text-emerald-600 focus:ring-emerald-500 rounded"
                                id="mthria_others_checkbox"
                                @if(is_array(old('mthria_addressed')) && in_array('OTHERS', old('mthria_addressed'))) checked @endif
                            >
                            <span class="ml-3 text-gray-800 font-medium text-sm">OTHERS</span>
                        </label>
                        <input
                            type="text"
                            name="mthria_others"
                            id="mthria_others_input"
                            class="mt-2 block w-full rounded-xl px-4 py-3 font-medium border border-gray-300"
                            placeholder="Please specify other MTHRIA"
                            style="display: none;"
                            value="{{ old('mthria_others') }}"
                        >
                    </div>
                    <x-input-error :messages="$errors->get('mthria_addressed')" class="mt-2" />
                    <div class="form-card rounded-2xl p-8">
                        <x-input-label value="Innovation" class="text-lg font-semibold text-gray-800 mb-6" />
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach(\App\Models\ref_agenda::all() as $agenda)
                            <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm cursor-pointer transition hover:bg-emerald-100 hover:shadow-md">
                                <input
                                    type="checkbox"
                                    name="agenda_addressed[]"
                                    value="{{ $agenda->agenda_code }}"
                                    class="form-checkbox text-emerald-600 focus:ring-emerald-500 rounded"
                                    {{ (collect(old('agenda_addressed'))->contains($agenda->agenda_code)) ? 'checked' : '' }}>
                                <span class="ml-3 text-gray-800 font-medium text-sm">{{ $agenda->agenda_desc }}</span>
                            </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('agenda_addressed')" class="mt-2" />
                    </div>
                    <!-- Subject Section -->
                    <div class="w-full flex justify-center mb-6 mt-2">
                        <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                            <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                SUBJECT
                            </h3>
                        </span>
                    </div>
                    <div class="form-card rounded-2xl p-8 mb-6">
                        <x-input-label for="mesh_keywords" value="MeSH Keywords" class="text-lg font-semibold text-gray-800 mb-4" />
                        <div class="flex items-center space-x-3 mb-4">
                            <input type="text" id="mesh_keywords_input" name="mesh_keywords_input" class="flex-1 rounded-xl px-4 py-3 font-medium" placeholder="Add MeSH keyword" />
                            <button type="button" id="add_mesh_keyword" class="w-10 h-10 bg-orange-500 text-white rounded-full hover:bg-orange-600 flex items-center justify-center transition-all duration-200 shadow-md hover:shadow-lg" title="Add MeSH Keyword">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <div id="mesh_keywords_chips" class="block w-full rounded-xl px-4 py-4 min-h-[120px] flex flex-wrap items-start content-start gap-2 bg-gray-50 border-2 border-dashed border-gray-300"></div>
                        <textarea id="mesh_keywords" name="mesh_keywords" rows="3" class="hidden">{{ is_array(old('mesh_keywords')) ? implode('; ', old('mesh_keywords')) : old('mesh_keywords') }}</textarea>
                        <x-input-error :messages="$errors->get('mesh_keywords')" class="mt-2" />
                    </div>
                    <div class="form-card rounded-2xl p-8 mb-6">
                        <x-input-label for="non_mesh_keywords" value="Non-MeSH Keywords" class="text-lg font-semibold text-gray-800 mb-4" />
                        <div class="flex items-center space-x-3 mb-4">
                            <input type="text" id="non_mesh_keywords_input" name="non_mesh_keywords_input" class="flex-1 rounded-xl px-4 py-3 font-medium" placeholder="Add Non-MeSH keyword" />
                            <button type="button" id="add_non_mesh_keyword" class="w-10 h-10 bg-orange-500 text-white rounded-full hover:bg-orange-600 flex items-center justify-center transition-all duration-200 shadow-md hover:shadow-lg" title="Add Non-MeSH Keyword">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <div id="non_mesh_keywords_chips" class="block w-full rounded-xl px-4 py-4 min-h-[120px] flex flex-wrap items-start content-start gap-2 bg-gray-50 border-2 border-dashed border-gray-300"></div>
                        <textarea id="non_mesh_keywords" name="non_mesh_keywords" rows="3" class="hidden">{{ is_array(old('non_mesh_keywords')) ? implode('; ', old('non_mesh_keywords')) : old('non_mesh_keywords') }}</textarea>
                        <x-input-error :messages="$errors->get('non_mesh_keywords')" class="mt-2" />
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            function parseKeywords(value) {
                                return value
                                    .split(';')
                                    .map(v => v.trim())
                                    .filter(v => v.length > 0);
                            }

                            function serializeKeywords(list) {
                                return list.join('; ') + (list.length ? '; ' : '');
                            }

                            function renderChips(container, keywords, onRemove) {
                                container.innerHTML = '';
                                keywords.forEach((kw, idx) => {
                                    const chip = document.createElement('span');
                                    chip.className = 'inline-flex items-center px-3 py-1 rounded-full border border-blue-300 text-blue-700 bg-white hover:bg-blue-50 text-sm';
                                    chip.innerHTML = `<span class="mr-2">${kw}</span>`;
                                    const btn = document.createElement('button');
                                    btn.type = 'button';
                                    btn.className = 'text-blue-500 hover:text-blue-700';
                                    btn.textContent = '×';
                                    btn.addEventListener('click', () => onRemove(idx));
                                    chip.appendChild(btn);
                                    container.appendChild(chip);
                                });
                            }

                            // MeSH
                            const meshInput = document.getElementById('mesh_keywords_input');
                            const meshTextarea = document.getElementById('mesh_keywords');
                            const meshChips = document.getElementById('mesh_keywords_chips');
                            let meshList = parseKeywords(meshTextarea.value || '');

                            function syncMesh() {
                                meshTextarea.value = serializeKeywords(meshList);
                                renderChips(meshChips, meshList, (idx) => {
                                    meshList.splice(idx, 1);
                                    syncMesh();
                                });
                            }
                            syncMesh();
                            document.getElementById('add_mesh_keyword')?.addEventListener('click', function() {
                                const val = meshInput.value.trim();
                                if (!val) return;
                                meshList.push(val);
                                meshInput.value = '';
                                syncMesh();
                            });
                            meshInput?.addEventListener('keydown', function(e) {
                                if (e.key === 'Enter') {
                                    e.preventDefault();
                                    document.getElementById('add_mesh_keyword').click();
                                }
                            });

                            // Non-MeSH
                            const nonMeshInput = document.getElementById('non_mesh_keywords_input');
                            const nonMeshTextarea = document.getElementById('non_mesh_keywords');
                            const nonMeshChips = document.getElementById('non_mesh_keywords_chips');
                            let nonMeshList = parseKeywords(nonMeshTextarea.value || '');

                            function syncNonMesh() {
                                nonMeshTextarea.value = serializeKeywords(nonMeshList);
                                renderChips(nonMeshChips, nonMeshList, (idx) => {
                                    nonMeshList.splice(idx, 1);
                                    syncNonMesh();
                                });
                            }
                            syncNonMesh();
                            document.getElementById('add_non_mesh_keyword')?.addEventListener('click', function() {
                                const val = nonMeshInput.value.trim();
                                if (!val) return;
                                nonMeshList.push(val);
                                nonMeshInput.value = '';
                                syncNonMesh();
                            });
                            nonMeshInput?.addEventListener('keydown', function(e) {
                                if (e.key === 'Enter') {
                                    e.preventDefault();
                                    document.getElementById('add_non_mesh_keyword').click();
                                }
                            });
                        });
                    </script>
                </div>
        </div>

        <div class="sticky bottom-0 z-10 -mx-12 px-12 py-6 bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/70 border-t border-gray-200 flex items-center justify-end gap-4 mt-12">
            <a href="{{ route('research.health_researches.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl text-base font-medium shadow-sm transition-all duration-200 hover:shadow-md">
                Cancel
            </a>
            <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-8 py-3 rounded-xl text-base font-semibold shadow-lg transition-all duration-200 flex items-center gap-3 hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Submit Research
            </button>
        </div>
        </form>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formEl = document.getElementById('health-research-form');
            const nextAccessionUrl = formEl ? formEl.getAttribute('data-next-accession-url') : null;
            const input = document.getElementById('accession_no');

            function fetchNext() {
                if (!nextAccessionUrl) return;
                fetch(nextAccessionUrl)
                    .then(r => r.json())
                    .then(d => {
                        if (d && d.next) input.value = d.next;
                        else input.value = 'Unavailable';
                    })
                    .catch(() => {
                        input.value = 'Unavailable';
                    });
            }
            fetchNext(); // Fetch on load
            setInterval(fetchNext, 10000); // Refresh every 10 seconds

            // Handle form submission to prevent focusability issues
            formEl.addEventListener('submit', function(e) {
                // Disable inputs inside hidden x-show sections to avoid submitting empty values
                const hiddenSections = formEl.querySelectorAll('[x-show][style*="display: none"]');
                hiddenSections.forEach(section => {
                    section.querySelectorAll('input, select, textarea').forEach(el => {
                        el.disabled = true;
                    });
                });

                // Also remove required from any hidden required fields as a safeguard
                const requiredFields = formEl.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    const container = field.closest('[x-show]');
                    if (container && container.style.display === 'none') {
                        field.removeAttribute('required');
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlCheckbox = document.getElementById('enter_url_nonprint');
            const urlInput = document.getElementById('url_input_nonprint');
            const uploadCheckbox = document.getElementById('upload_file_nonprint');
            const fileInput = document.getElementById('file_upload_nonprint');
            const nonprintError = document.getElementById('nonprint-upload-url-error');
            if (urlCheckbox && urlInput) {
                function toggleUrlInput() {
                    urlInput.disabled = !urlCheckbox.checked;
                }
                urlCheckbox.addEventListener('change', toggleUrlInput);
                toggleUrlInput();
            }
            if (uploadCheckbox && fileInput) {
                function toggleFileInput() {
                    fileInput.disabled = !uploadCheckbox.checked;
                }
                uploadCheckbox.addEventListener('change', toggleFileInput);
                toggleFileInput();
            }

            // Validate that at least one of URL or File is selected for Non-Print before submit
            const form = document.getElementById('health-research-form');
            form.addEventListener('submit', function(e) {
                const formatSelect = document.querySelector('[name="format[]"]');
                const isNonPrint = formatSelect && formatSelect.value === 'Non-Print';
                if (isNonPrint) {
                    const hasUrl = urlCheckbox && urlCheckbox.checked && urlInput && urlInput.value.trim().length > 0;
                    const hasFile = uploadCheckbox && uploadCheckbox.checked && fileInput && fileInput.files && fileInput.files.length > 0;
                    if (!hasUrl && !hasFile) {
                        e.preventDefault();
                        if (nonprintError) {
                            nonprintError.classList.remove('hidden');
                        }
                        // Focus URL checkbox for guidance
                        if (urlCheckbox) urlCheckbox.focus();
                    } else if (nonprintError) {
                        nonprintError.classList.add('hidden');
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // NUHRA OTHERS
            const nuhraOthersCheckbox = document.getElementById('nuhra_others_checkbox');
            const nuhraOthersInput = document.getElementById('nuhra_others_input');
            if (nuhraOthersCheckbox && nuhraOthersInput) {
                function toggleNuhraOthers() {
                    nuhraOthersInput.style.display = nuhraOthersCheckbox.checked ? 'block' : 'none';
                    nuhraOthersInput.required = nuhraOthersCheckbox.checked;
                }
                nuhraOthersCheckbox.addEventListener('change', toggleNuhraOthers);
                toggleNuhraOthers();
            }
            // MTHRIA OTHERS
            const mthriaOthersCheckbox = document.getElementById('mthria_others_checkbox');
            const mthriaOthersInput = document.getElementById('mthria_others_input');
            if (mthriaOthersCheckbox && mthriaOthersInput) {
                function toggleMthriaOthers() {
                    mthriaOthersInput.style.display = mthriaOthersCheckbox.checked ? 'block' : 'none';
                    mthriaOthersInput.required = mthriaOthersCheckbox.checked;
                }
                mthriaOthersCheckbox.addEventListener('change', toggleMthriaOthers);
                toggleMthriaOthers();
            }
        });
    </script>
</x-app-layout>
