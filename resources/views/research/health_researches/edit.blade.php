<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight tracking-tight">
                <span class="inline-flex items-center gap-2">
                    <svg class="w-7 h-7 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Edit Health Research') }}
                </span>
            </h2>
        </div>
    </x-slot>

    @php
        $sdgSelected = collect(explode(';', (string)($healthResearch->sdg_addressed ?? '')))->map(fn($v) => trim($v))->filter()->values();
        $nuhraSelected = collect(explode(';', (string)($healthResearch->nuhra_addressed ?? '')))->map(fn($v) => trim($v))->filter()->values();
        $mthriaSelected = collect(explode(';', (string)($healthResearch->mthria_addressed ?? '')))->map(fn($v) => trim($v))->filter()->values();
        $agendaSelected = collect(explode(';', (string)($healthResearch->agenda_addressed ?? '')))->map(fn($v) => trim($v))->filter()->values();
    @endphp

    <div class="py-10 min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-emerald-50" style="padding-top: 0px;">
        <div class="max-w-7xl mx-auto px-6">
            <style>
                #health-research-form { background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.5); }
                #health-research-form label { color: #1e293b !important; font-weight: 600 !important; font-size: 0.95rem; }
                #health-research-form .form-asterisk { color: #dc2626; font-weight: 700; font-size: 1.75em; line-height: 1; margin-left: 0.15em; position: relative; top: 0.3em; }
                #health-research-form input[type="text"],
                #health-research-form input[type="email"],
                #health-research-form input[type="number"],
                #health-research-form input[type="url"],
                #health-research-form textarea,
                #health-research-form select { background: #ffffff; border: 2px solid #e2e8f0; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); }
                #health-research-form input[type="text"]:focus,
                #health-research-form input[type="email"]:focus,
                #health-research-form input[type="number"]:focus,
                #health-research-form input[type="url"]:focus,
                #health-research-form textarea:focus,
                #health-research-form select:focus { border-color: #14532d; box-shadow: 0 0 0 3px rgba(20, 83, 45, 0.1), 0 4px 6px -1px rgba(0, 0, 0, 0.1); background: #ffffff; }
                .section-header { background: linear-gradient(135deg, #14532d 0%, #14532d 100%); box-shadow: 0 4px 14px 0 rgba(20, 83, 45, 0.3); }
                .form-card { background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; }
                .form-card:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
                .bg-gradient-to-r.from-emerald-600.to-emerald-800.bg-clip-text.text-transparent { background: none !important; color: #14532d !important; background-clip: unset !important; -webkit-background-clip: unset !important; -webkit-text-fill-color: unset !important; }
            </style>

            <form id="health-research-form" method="POST" action="{{ route('research.health_researches.update', $healthResearch) }}" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-2xl px-12 pb-12 space-y-12">
                @csrf
                @method('PUT')

                <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-emerald-800 bg-clip-text text-transparent mb-2">Edit Health Research</h2>
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
                                    if (["INPUT", "SELECT", "TEXTAREA"].includes(node.tagName)) return;
                                    Array.from(node.childNodes).forEach(wrapAsterisksInNode);
                                }
                            }
                            Array.from(label.childNodes).forEach(wrapAsterisksInNode);
                        });
                    });
                </script>

                <div class="space-y-8">
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
                                <input type="text" name="accession_no" id="accession_no" class="block w-full rounded-xl px-4 py-3 text-base font-medium" style="height:48px; min-height:48px; max-width:350px;" value="{{ old('accession_no', $healthResearch->accession_no) }}" readonly>
                            </div>
                            <div class="flex-1">
                                <x-input-label for="research_title" value="Research Title *" class="text-lg font-semibold text-gray-800 mb-2" />
                                <textarea name="research_title" id="research_title" class="block w-full rounded-xl px-4 py-3 text-lg font-medium resize-y" maxlength="500" style="height:48px; min-height:48px; max-height:180px;" placeholder="Enter research title (up to 500 characters)">{{ old('research_title', $healthResearch->research_title) }}</textarea>
                                <x-input-error :messages="$errors->get('research_title')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-6">
                            <x-input-label value="Subtitle" class="text-lg font-semibold text-gray-800 mb-2" />
                            <textarea name="subtitle" id="subtitle" class="block w-full rounded-xl px-4 py-3 text-lg font-medium resize-y" maxlength="500" style="height:48px; min-height:48px; max-height:180px;" placeholder="Enter research subtitle (up to 500 characters)">{{ old('subtitle', $healthResearch->subtitle) }}</textarea>
                            <x-input-error :messages="$errors->get('subtitle')" class="mt-2" />
                        </div>
                    </div>

                    <div class="w-full flex justify-center mb-6 mt-2">
                        <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                            <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">SOURCE</h3>
                        </span>
                    </div>

                    <div class="form-card rounded-2xl p-8">
                        <x-input-label value="Date Issued *" class="text-lg font-semibold text-gray-800 mb-4" />
                        <div x-data="{ mode: '{{ old('date_issued_mode', ($healthResearch->date_issued_from_month ? 'month_year' : 'year_only')) }}', fromMonth: '{{ old('date_issued_from_month', $healthResearch->date_issued_from_month) }}', fromYear: '{{ old('date_issued_from_year', $healthResearch->date_issued_from_year) }}', toMonth: '{{ old('date_issued_to_month', $healthResearch->date_issued_to_month) }}', toYear: '{{ old('date_issued_to_year', $healthResearch->date_issued_to_year) }}', months: [{num:1,name:'Jan'},{num:2,name:'Feb'},{num:3,name:'Mar'},{num:4,name:'Apr'},{num:5,name:'May'},{num:6,name:'Jun'},{num:7,name:'Jul'},{num:8,name:'Aug'},{num:9,name:'Sep'},{num:10,name:'Oct'},{num:11,name:'Nov'},{num:12,name:'Dec'}], yearPattern:/^[0-9]{4}$/, validateYear(val){return this.yearPattern.test(val);} }" class="flex flex-col gap-4">
                            <div class="flex gap-6 items-center mb-2">
                                <label class="inline-flex items-center px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-lg cursor-pointer transition hover:bg-emerald-100">
                                    <input type="radio" name="date_issued_mode" value="month_year" x-model="mode" class="form-radio text-emerald-600 focus:ring-emerald-500" {{ old('date_issued_mode', ($healthResearch->date_issued_from_month ? 'month_year' : 'year_only')) === 'month_year' ? 'checked' : '' }}>
                                    <span class="ml-3 text-gray-700 font-medium">Month & Year</span>
                                </label>
                                <label class="inline-flex items-center px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-lg cursor-pointer transition hover:bg-emerald-100">
                                    <input type="radio" name="date_issued_mode" value="year_only" x-model="mode" class="form-radio text-emerald-600 focus:ring-emerald-500" {{ old('date_issued_mode', ($healthResearch->date_issued_from_month ? 'month_year' : 'year_only')) === 'year_only' ? 'checked' : '' }}>
                                    <span class="ml-3 text-gray-700 font-medium">Year Only</span>
                                </label>
                            </div>
                            <div class="flex flex-wrap gap-4 mt-2">
                                <template x-if="mode === 'month_year'">
                                    <div class="flex flex-wrap gap-4 w-full items-end">
                                        <div class="flex-1 min-w-[120px]">
                                            <x-input-label for="date_issued_from_month" value="From Month" class="text-sm font-medium text-gray-700 mb-1" />
                                            <select id="date_issued_from_month" name="date_issued_from_month" class="block w-full rounded-xl px-4 py-3 font-medium" x-model="fromMonth" required>
                                                <option value="">Select Month</option>
                                                <template x-for="m in months" :key="m.num">
                                                    <option :value="m.num" x-text="m.name" :selected="fromMonth == m.num"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div class="flex-1 min-w-[100px]">
                                            <x-input-label for="date_issued_from_year" value="From Year" class="text-sm font-medium text-gray-700 mb-1" />
                                            <input type="text" id="date_issued_from_year" name="date_issued_from_year" class="block w-full rounded-xl px-4 py-3 font-medium" x-model="fromYear" maxlength="4" pattern="[0-9]{4}" placeholder="YYYY" required @input="if (!validateYear($event.target.value) && $event.target.value.length > 0) { $event.target.setCustomValidity('Please enter a valid 4-digit year'); } else { $event.target.setCustomValidity(''); }" />
                                        </div>
                                        <span class="self-center px-3 py-2 text-gray-500 font-medium">to</span>
                                        <div class="flex-1 min-w-[120px]">
                                            <x-input-label for="date_issued_to_month" value="To Month" class="text-sm font-medium text-gray-700 mb-1" />
                                            <select id="date_issued_to_month" name="date_issued_to_month" class="block w-full rounded-xl px-4 py-3 font-medium" x-model="toMonth" required>
                                                <option value="">Select Month</option>
                                                <template x-for="m in months" :key="m.num">
                                                    <option :value="m.num" x-text="m.name" :selected="toMonth == m.num"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div class="flex-1 min-w-[100px]">
                                            <x-input-label for="date_issued_to_year" value="To Year" class="text-sm font-medium text-gray-700 mb-1" />
                                            <input type="text" id="date_issued_to_year" name="date_issued_to_year" class="block w-full rounded-xl px-4 py-3 font-medium" x-model="toYear" maxlength="4" pattern="[0-9]{4}" placeholder="YYYY" required @input="if (!validateYear($event.target.value) && $event.target.value.length > 0) { $event.target.setCustomValidity('Please enter a valid 4-digit year'); } else { $event.target.setCustomValidity(''); }" />
                                        </div>
                                    </div>
                                </template>
                                <template x-if="mode === 'year_only'">
                                    <div class="flex flex-wrap gap-4">
                                        <div class="flex-1 min-w-[200px]">
                                            <x-input-label for="date_issued_from_year" value="Year" class="text-sm font-medium text-gray-700 mb-1" />
                                            <input type="text" id="date_issued_from_year" name="date_issued_from_year" class="block w-full rounded-xl px-4 py-3 font-medium" x-model="fromYear" maxlength="4" pattern="[0-9]{4}" placeholder="YYYY" required @input="if (!validateYear($event.target.value) && $event.target.value.length > 0) { $event.target.setCustomValidity('Please enter a valid 4-digit year'); } else { $event.target.setCustomValidity(''); }" />
                                        </div>
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

                    <div class="form-card rounded-2xl p-8">
                        <x-input-label value="Publication Details" class="text-lg font-semibold text-gray-800 mb-6" />
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="volume_no" value="Volume No." class="text-sm font-medium text-gray-700 mb-2" />
                                <input id="volume_no" name="volume_no" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('volume_no', $healthResearch->volume_no) }}"/>
                                <x-input-error :messages="$errors->get('volume_no')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="issue_no" value="Issue No." class="text-sm font-medium text-gray-700 mb-2" />
                                <input id="issue_no" name="issue_no" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('issue_no', $healthResearch->issue_no) }}" />
                                <x-input-error :messages="$errors->get('issue_no')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="pages" value="Page(s)" class="text-sm font-medium text-gray-700 mb-2" />
                                <input id="pages" name="pages" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('pages', $healthResearch->pages) }}" />
                                <x-input-error :messages="$errors->get('pages')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="article_no" value="Article No." class="text-sm font-medium text-gray-700 mb-2" />
                                <input id="article_no" name="article_no" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('article_no', $healthResearch->article_no) }}" />
                                <x-input-error :messages="$errors->get('article_no')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="doi" value="DOI" class="text-sm font-medium text-gray-700 mb-2" />
                                <input id="doi" name="doi" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('doi', $healthResearch->doi) }}" />
                                <x-input-error :messages="$errors->get('doi')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="implementing_agency" value="Implementing Agency" class="text-sm font-medium text-gray-700 mb-2" />
                                <input type="text" name="implementing_agency" id="implementing_agency" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('implementing_agency', $healthResearch->implementing_agency) }}">
                            </div>
                            <div>
                                <x-input-label for="cooperating_agency" value="Cooperating Agency" class="text-sm font-medium text-gray-700 mb-2" />
                                <input type="text" name="cooperating_agency" id="cooperating_agency" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('cooperating_agency', $healthResearch->cooperating_agency) }}">
                            </div>
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Left column: radios + budget/currency -->
                                <div>
                                    <x-input-label value="Is this research funded by the government?" class="text-sm font-medium text-gray-700 mb-2" />
                                    @php $isGov = old('is_gov_fund', $healthResearch->is_gov_fund); @endphp
                                    <div class="flex gap-6 mt-1">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="is_gov_fund" value="yes" {{ $isGov === 'yes' ? 'checked' : '' }} class="form-radio text-emerald-600 focus:ring-emerald-500">
                                            <span class="ml-2 text-gray-800">Yes</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="is_gov_fund" value="no" {{ $isGov === 'no' ? 'checked' : '' }} class="form-radio text-emerald-600 focus:ring-emerald-500">
                                            <span class="ml-2 text-gray-800">No</span>
                                        </label>
                                    </div>
                                    <x-input-error :messages="$errors->get('is_gov_fund')" class="mt-2" />
                                    <div id="gov-fund-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <label for="budget" class="text-sm font-medium text-gray-700 mb-2 flex items-center">Research Budget</label>
                                            <input type="number" class="block w-full rounded-xl px-4 py-3 font-medium" id="budget" name="budget" step="0.01" min="0" style="max-width:350px;" value="{{ old('budget', $healthResearch->budget) }}">
                                            <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                                        </div>
                                        <div>
                                            <label for="currency_code" class="text-sm font-medium text-gray-700 mb-2 flex items-center">Currency</label>
                                            <select id="currency_code" name="currency_code" class="block w-full rounded-xl px-4 py-3 font-medium" style="max-width:350px;">
                                                <option value="">Select currency</option>
                                                @php $currencies = \DB::table('ref_currency')->orderBy('currency_desc')->get(); @endphp
                                                @foreach($currencies as $currency)
                                                    <option value="{{ $currency->currency_code }}" {{ old('currency_code', $healthResearch->currency_code) == $currency->currency_code ? 'selected' : '' }}>{{ $currency->currency_desc }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('currency_code')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Right column: funding agency -->
                                <div>
                                    <x-input-label for="funding_agency" value="Funding Agency" class="text-sm font-medium text-gray-700 mb-2" />
                                    <input type="text" name="funding_agency" id="funding_agency" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('funding_agency', $healthResearch->funding_agency) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-card rounded-2xl p-8">
                        <x-input-label for="notes" value="General Notes" class="text-lg font-semibold text-gray-800 mb-4" />
                        <textarea id="notes" name="notes" rows="4" class="block w-full rounded-xl px-4 py-3 font-medium resize-y" placeholder="Enter any additional notes here...">{{ old('notes', $healthResearch->notes) }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="form-card rounded-2xl p-8">
                        <x-input-label value="Research Category *" class="text-lg font-semibold text-gray-800 mb-4" />
                        <div class="flex flex-wrap gap-4">
                            @php $rc = old('research_category', $healthResearch->research_category); @endphp
                            <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl cursor-pointer transition hover:bg-emerald-100">
                                <input type="radio" name="research_category" value="Institutional" {{ $rc == 'Institutional' ? 'checked' : '' }} required class="form-radio text-emerald-600 focus:ring-emerald-500" />
                                <span class="ml-3 text-gray-700 font-medium">Institutional</span>
                            </label>
                            <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl cursor-pointer transition hover:bg-emerald-100">
                                <input type="radio" name="research_category" value="Collaborative" {{ $rc == 'Collaborative' ? 'checked' : '' }} required class="form-radio text-emerald-600 focus:ring-emerald-500" />
                                <span class="ml-3 text-gray-700 font-medium">Collaborative</span>
                            </label>
                            <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl cursor-pointer transition hover:bg-emerald-100">
                                <input type="radio" name="research_category" value="Commissioned" {{ $rc == 'Commissioned' ? 'checked' : '' }} required class="form-radio text-emerald-600 focus:ring-emerald-500" />
                                <span class="ml-3 text-gray-700 font-medium">Commissioned</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('research_category')" class="mt-2" />
                    </div>

                    <div class="form-card rounded-2xl p-8">
                        <x-input-label value="Research Type *" class="text-lg font-semibold text-gray-800 mb-4" />
                        <div class="flex flex-wrap gap-4">
                            @php $rt = old('research_type', $healthResearch->research_type); @endphp
                            <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl cursor-pointer transition hover:bg-emerald-100">
                                <input type="radio" name="research_type" value="Basic" {{ $rt == 'Basic' ? 'checked' : '' }} required class="form-radio text-emerald-600 focus:ring-emerald-500" />
                                <span class="ml-3 text-gray-700 font-medium">Basic</span>
                            </label>
                            <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl cursor-pointer transition hover:bg-emerald-100">
                                <input type="radio" name="research_type" value="Applied" {{ $rt == 'Applied' ? 'checked' : '' }} required class="form-radio text-emerald-600 focus:ring-emerald-500" />
                                <span class="ml-3 text-gray-700 font-medium">Applied</span>
                            </label>
                            <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl cursor-pointer transition hover:bg-emerald-100">
                                <input type="radio" name="research_type" value="Experimental" {{ $rt == 'Experimental' ? 'checked' : '' }} required class="form-radio text-emerald-600 focus:ring-emerald-500" />
                                <span class="ml-3 text-gray-700 font-medium">Experimental</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('research_type')" class="mt-2" />
                    </div>

                    <div class="w-full flex justify-center mb-6 mt-2">
                        <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                            <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">AUTHOR</h3>
                        </span>
                    </div>

                    @php $authors = $healthResearch->authors ?? collect(); @endphp
                    @if($authors->isEmpty())
                        @php $authors = collect([null]); @endphp
                    @endif
                    @foreach($authors as $idx => $author)
                        <div class="form-card rounded-2xl p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div>
                                    <x-input-label for="author_last_name_{{ $idx }}" value="Last Name" class="text-sm font-medium text-gray-700 mb-2" />
                                    <input id="author_last_name_{{ $idx }}" name="author_last_name[]" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('author_last_name.'.$idx, optional($author)->last_name) }}" />
                                    <x-input-error :messages="$errors->get('author_last_name.*')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="author_first_name_{{ $idx }}" value="First Name" class="text-sm font-medium text-gray-700 mb-2" />
                                    <input id="author_first_name_{{ $idx }}" name="author_first_name[]" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('author_first_name.'.$idx, optional($author)->first_name) }}" />
                                    <x-input-error :messages="$errors->get('author_first_name.*')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="author_middle_name_{{ $idx }}" value="Middle Name" class="text-sm font-medium text-gray-700 mb-2" />
                                    <input id="author_middle_name_{{ $idx }}" name="author_middle_name[]" type="text" class="block w-full rounded-xl px-4 py-3 font-medium" value="{{ old('author_middle_name.'.$idx, optional($author)->middle_name) }}" />
                                    <x-input-error :messages="$errors->get('author_middle_name.*')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="author_suffix_{{ $idx }}" value="Suffix" class="text-sm font-medium text-gray-700 mb-2" />
                                    <select id="author_suffix_{{ $idx }}" name="author_suffix[]" class="block w-full rounded-xl px-4 py-3 font-medium">
                                        @php $suffixVal = old('author_suffix.'.$idx, optional($author)->suffix); @endphp
                                        <option value="">-- Select --</option>
                                        @foreach(['Jr.','Sr.','I','II','III','IV','V','Ph.D.','M.D.','M.Sc.','B.Sc.'] as $sfx)
                                            <option value="{{ $sfx }}" {{ $suffixVal === $sfx ? 'selected' : '' }}>{{ $sfx }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('author_suffix.*')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="w-full flex justify-center mb-6 mt-2">
                        <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                            <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">ABSTRACT</h3>
                        </span>
                    </div>

                    <div class="form-card rounded-2xl p-8">
                        <div class="mb-6">
                            <x-input-label for="abstract_type" value="Abstract Type" class="text-sm font-medium text-gray-700 mb-2" />
                            <select id="abstract_type" name="abstract_type" class="block w-full rounded-xl px-4 py-3 font-medium">
                                <option value="Full Abstract" {{ old('abstract_type', $healthResearch->abstract_type) === 'Full Abstract' ? 'selected' : '' }}>Full Abstract</option>
                            </select>
                            <x-input-error :messages="$errors->get('abstract_type')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="research_abstract" value="Abstract Content" class="text-sm font-medium text-gray-700 mb-2" />
                            <textarea id="research_abstract" name="research_abstract" rows="8" class="block w-full rounded-xl px-4 py-3 font-medium resize-y" placeholder="Enter your research abstract here...">{{ old('research_abstract', $healthResearch->research_abstract) }}</textarea>
                            <x-input-error :messages="$errors->get('research_abstract')" class="mt-2" />
                        </div>
                    </div>

                    <div class="w-full flex justify-center mb-6 mt-2">
                        <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                            <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">REFERENCE / CITATION</h3>
                        </span>
                    </div>

                    <div class="form-card rounded-2xl p-8">
                        <x-input-label for="reference" value="Reference / Citation" class="text-lg font-semibold text-gray-800 mb-4" />
                        <textarea id="reference" name="reference" rows="6" class="block w-full rounded-xl px-4 py-3 font-medium resize-y" placeholder="Enter your references here...">{{ old('reference', $healthResearch->reference) }}</textarea>
                        <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                    </div>

                    <div class="w-full flex justify-center mb-6 mt-2">
                        <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                            <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">LOCATION</h3>
                        </span>
                    </div>

                    @php $locations = $healthResearch->locations ?? collect(); @endphp
                    @if($locations->isEmpty())
                        @php $locations = collect([null]); @endphp
                    @endif
                    @foreach($locations as $lidx => $loc)
                        @php
                            $formatVal = old('format.'.$lidx, optional($loc)->format);
                            $modeVal = old('mode_of_access.'.$lidx, optional($loc)->mode_of_access);
                        @endphp
                        <div class="form-card rounded-2xl p-8">
                            <p class="text-gray-600 italic mb-6 text-sm">Please input the location where the material can be viewed or accessed.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <x-input-label for="format_{{ $lidx }}" value="Format *" class="text-sm font-medium text-gray-700 mb-2" />
                                    <select id="format_{{ $lidx }}" name="format[]" class="block w-full rounded-xl px-4 py-3 font-medium" required>
                                        <option value="">Select Format</option>
                                        <option value="Print" {{ $formatVal === 'Print' ? 'selected' : '' }}>Print</option>
                                        <option value="Non-Print" {{ $formatVal === 'Non-Print' ? 'selected' : '' }}>Non-Print</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('format.*')" class="mt-2" />
                                </div>
                            </div>

                            <div class="print-fields" @if($formatVal !== 'Print') style="display:none" @endif>
                                <div class="mb-6">
                                    <x-input-label for="physical_location_print_{{ $lidx }}" value="Physical Location" />
                                    <x-text-input id="physical_location_print_{{ $lidx }}" name="physical_location[]" type="text" class="mt-1 block w-full" value="{{ old('physical_location.'.$lidx, optional($loc)->physical_location) }}" placeholder="Location" />
                                    <x-input-error :messages="$errors->get('physical_location.*')" class="mt-2" />
                                </div>
                                <div class="mb-6">
                                    <x-input-label for="location_number_print_{{ $lidx }}" value="Location Number" />
                                    <x-text-input id="location_number_print_{{ $lidx }}" name="location_number[]" type="text" class="mt-1 block w-full" value="{{ old('location_number.'.$lidx, optional($loc)->location_number) }}" />
                                    <x-input-error :messages="$errors->get('location_number.*')" class="mt-2" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                    <div class="flex flex-col">
                                        <x-input-label for="text_availability_print_{{ $lidx }}" value="Text Availability *" class="text-sm font-medium text-gray-700 mb-2" />
                                        @php $ta = old('text_availability.'.$lidx, optional($loc)->text_availability); @endphp
                                        <select id="text_availability_print_{{ $lidx }}" name="text_availability[]" class="block w-full rounded-xl px-4 py-3 font-medium">
                                            <option value="">Select Text Availability</option>
                                            <option value="Abstract Only" {{ $ta === 'Abstract Only' ? 'selected' : '' }}>Abstract Only</option>
                                            <option value="Full-text" {{ $ta === 'Full-text' ? 'selected' : '' }}>Full-text</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('text_availability.*')" class="mt-2" />
                                    </div>
                                    <div class="flex flex-col">
                                        <x-input-label for="mode_of_access_print_{{ $lidx }}" value="Mode of Access *" class="text-sm font-medium text-gray-700 mb-2" />
                                        <select id="mode_of_access_print_{{ $lidx }}" name="mode_of_access[]" class="block w-full rounded-xl px-4 py-3 font-medium">
                                            <option value="">Select Mode of Access</option>
                                            <option value="Request to Institution" {{ $modeVal === 'Request to Institution' ? 'selected' : '' }}>Request to Institution</option>
                                            <option value="Room use Only" {{ $modeVal === 'Room use Only' ? 'selected' : '' }}>Room use Only</option>
                                            <option value="Not available to the public" {{ $modeVal === 'Not available to the public' ? 'selected' : '' }}>Not available to the public</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('mode_of_access.*')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="mb-6 inst-email" @if($modeVal !== 'Request to Institution') style="display:none" @endif>
                                    <x-input-label for="institutional_email_print_{{ $lidx }}" value="Institutional Email *" />
                                    <x-text-input id="institutional_email_print_{{ $lidx }}" name="institutional_email[]" type="email" class="mt-1 block w-full" value="{{ old('institutional_email.'.$lidx, optional($loc)->institutional_email) }}" placeholder="Institution Email" />
                                    <x-input-error :messages="$errors->get('institutional_email.*')" class="mt-2" />
                                </div>
                            </div>

                            <div class="nonprint-fields" @if($formatVal !== 'Non-Print') style="display:none" @endif>
                                <div class="mb-6">
                                    <x-input-label for="physical_location_nonprint_{{ $lidx }}" value="Location *" />
                                    <x-text-input id="physical_location_nonprint_{{ $lidx }}" name="physical_location[]" type="text" class="mt-1 block w-full" value="{{ old('physical_location.'.$lidx, optional($loc)->physical_location) }}" placeholder="Location" />
                                    <x-input-error :messages="$errors->get('physical_location.*')" class="mt-2" />
                                </div>
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                    <h4 class="text-sm font-medium text-blue-900 mb-3">Please tick any of the two choices:</h4>
                                    @php
                                        $enterUrlChecked = old('enter_url.'.$lidx, optional($loc)->enter_url) ? true : false;
                                        $uploadFileChecked = old('upload_file.'.$lidx, optional($loc)->upload_file) ? true : false;
                                    @endphp
                                    <div class="space-y-3">
                                        <div class="flex items-center space-x-3">
                                            <input type="checkbox" id="enter_url_nonprint_{{ $lidx }}" name="enter_url[]" value="1" {{ $enterUrlChecked ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="enter_url_nonprint_{{ $lidx }}" class="text-sm text-blue-900">Enter URL</label>
                                            <input type="url" name="url[]" id="url_input_nonprint_{{ $lidx }}" class="flex-1 ml-2 text-sm text-gray-500 border border-gray-300 rounded px-3 py-2" value="{{ old('url.'.$lidx, optional($loc)->url) }}" placeholder="https://example.com" @if(!$enterUrlChecked) disabled @endif/>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <input type="checkbox" id="upload_file_nonprint_{{ $lidx }}" name="upload_file[]" value="1" {{ $uploadFileChecked ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="upload_file_nonprint_{{ $lidx }}" class="text-sm text-blue-900">Upload File</label>
                                            <input type="file" name="file[]" id="file_upload_nonprint_{{ $lidx }}" class="flex-1 ml-2 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" @if(!$uploadFileChecked) disabled @endif />
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                    <div class="flex flex-col">
                                        <x-input-label for="text_availability_nonprint_{{ $lidx }}" value="Text Availability *" class="text-sm font-medium text-gray-700 mb-2" />
                                        @php $ta2 = old('text_availability.'.$lidx, optional($loc)->text_availability); @endphp
                                        <select id="text_availability_nonprint_{{ $lidx }}" name="text_availability[]" class="block w-full rounded-xl px-4 py-3 font-medium">
                                            <option value="">Select Text Availability</option>
                                            <option value="Abstract Only" {{ $ta2 === 'Abstract Only' ? 'selected' : '' }}>Abstract Only</option>
                                            <option value="Full-text" {{ $ta2 === 'Full-text' ? 'selected' : '' }}>Full-text</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('text_availability.*')" class="mt-2" />
                                    </div>
                                    <div class="flex flex-col">
                                        <x-input-label for="mode_of_access_nonprint_{{ $lidx }}" value="Mode of Access *" class="text-sm font-medium text-gray-700 mb-2" />
                                        <select id="mode_of_access_nonprint_{{ $lidx }}" name="mode_of_access[]" class="block w-full rounded-xl px-4 py-3 font-medium">
                                            <option value="">Select Mode of Access</option>
                                            <option value="Online Request" {{ $modeVal === 'Online Request' ? 'selected' : '' }}>Online Request</option>
                                            <option value="Publicly accessible" {{ $modeVal === 'Publicly accessible' ? 'selected' : '' }}>Publicly accessible</option>
                                            <option value="Not available to the public" {{ $modeVal === 'Not available to the public' ? 'selected' : '' }}>Not available to the public</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('mode_of_access.*')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="form-card rounded-2xl p-8">
                    <x-input-label for="status" value="Status" class="text-sm font-medium text-gray-700 mb-2" />
                    @php $st = old('status', $healthResearch->status); @endphp
                    <select name="status" id="status" class="block w-full rounded-xl px-4 py-3 font-medium">
                        <option value="">Select Status</option>
                        <option value="Ongoing" {{ $st == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="Completed" {{ $st == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="w-full flex justify-center mb-6 mt-2">
                    <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                        <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">Focus Area</h3>
                    </span>
                </div>
                <div class="form-card rounded-2xl p-8">
                    <x-input-label class="text-lg font-semibold text-gray-800 mb-6">SDG Addressed <span class="text-red-500">* (You may select more than one SDG.)</span></x-input-label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach(\App\Models\ref_sdgs::all() as $sdg)
                            @php $checked = collect(old('sdg_addressed', $sdgSelected))->contains($sdg->sdg_code); @endphp
                            <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm cursor-pointer transition hover:bg-emerald-100 hover:shadow-md">
                                <input type="checkbox" name="sdg_addressed[]" value="{{ $sdg->sdg_code }}" class="form-checkbox text-emerald-600 focus:ring-emerald-500 rounded" {{ $checked ? 'checked' : '' }}>
                                <span class="ml-3 text-gray-800 font-medium text-sm">{{ $sdg->sdg_desc }}</span>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('sdg_addressed')" class="mt-2" />
                </div>

                <div class="w-full flex justify-center mb-6 mt-2">
                    <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                        <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">National Unified Health Research Agenda of the Philippines</h3>
                    </span>
                </div>
                <div class="form-card rounded-2xl p-8">
                    <x-input-label class="text-lg font-semibold text-gray-800 mb-6">NUHRA <span class="text-red-500">* (You may select more than one NUHRA.)</span></x-input-label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach(\App\Models\ref_nuhra::all() as $nuhra)
                            @php $checked = collect(old('nuhra_addressed', $nuhraSelected))->contains($nuhra->nuhra_code); @endphp
                            <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm cursor-pointer transition hover:bg-emerald-100 hover:shadow-md">
                                <input type="checkbox" name="nuhra_addressed[]" value="{{ $nuhra->nuhra_code }}" class="form-checkbox text-emerald-600 focus:ring-emerald-500 rounded" {{ $checked ? 'checked' : '' }}>
                                <span class="ml-3 text-gray-800 font-medium text-sm">{{ $nuhra->nuhra_desc }}</span>
                            </label>
                        @endforeach
                        @php $nuhraOld = old('nuhra_addressed', $nuhraSelected->toArray()); @endphp
                        <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm cursor-pointer transition hover:bg-emerald-100 hover:shadow-md">
                            <input type="checkbox" name="nuhra_addressed[]" value="OTHERS" class="form-checkbox text-emerald-600 focus:ring-emerald-500 rounded" id="nuhra_others_checkbox" {{ in_array('OTHERS', (array)$nuhraOld) ? 'checked' : '' }}>
                            <span class="ml-3 text-gray-800 font-medium text-sm">OTHERS</span>
                        </label>
                        <input type="text" name="nuhra_others" id="nuhra_others_input" class="mt-2 block w-full rounded-xl px-4 py-3 font-medium border border-gray-300" placeholder="Please specify other NUHRA" style="display: none;" value="{{ old('nuhra_others', $healthResearch->nuhra_others) }}">
                    </div>
                    <x-input-error :messages="$errors->get('nuhra_addressed')" class="mt-2" />
                </div>

                <div class="w-full flex justify-center mb-6 mt-2">
                    <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                        <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">Medium-Term Health Research and Innovation Agenda (MTHRIA)</h3>
                    </span>
                </div>
                <div class="form-card rounded-2xl p-8">
                    <x-input-label class="text-lg font-semibold text-gray-800 mb-6">MTHRIA <span class="text-red-500">* (You may select more than one MTHRIA.)</span></x-input-label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pb-4">
                        @foreach(\App\Models\ref_mthria::all() as $mthria)
                            @php $checked = collect(old('mthria_addressed', $mthriaSelected))->contains($mthria->mthria_code); @endphp
                            <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm cursor-pointer transition hover:bg-emerald-100 hover:shadow-md">
                                <input type="checkbox" name="mthria_addressed[]" value="{{ $mthria->mthria_code }}" class="form-checkbox text-emerald-600 focus:ring-emerald-500 rounded" {{ $checked ? 'checked' : '' }}>
                                <span class="ml-3 text-gray-800 font-medium text-sm">{{ $mthria->mthria_desc }}</span>
                            </label>
                        @endforeach
                        @php $mthriaOld = old('mthria_addressed', $mthriaSelected->toArray()); @endphp
                        <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm cursor-pointer transition hover:bg-emerald-100 hover:shadow-md">
                            <input type="checkbox" name="mthria_addressed[]" value="OTHERS" class="form-checkbox text-emerald-600 focus:ring-emerald-500 rounded" id="mthria_others_checkbox" {{ in_array('OTHERS', (array)$mthriaOld) ? 'checked' : '' }}>
                            <span class="ml-3 text-gray-800 font-medium text-sm">OTHERS</span>
                        </label>
                        <input type="text" name="mthria_others" id="mthria_others_input" class="mt-2 block w-full rounded-xl px-4 py-3 font-medium border border-gray-300" placeholder="Please specify other MTHRIA" style="display: none;" value="{{ old('mthria_others', $healthResearch->mthria_others) }}">
                    </div>
                    <x-input-error :messages="$errors->get('mthria_addressed')" class="mt-2" />

                    <div class="form-card rounded-2xl p-8">
                        <x-input-label value="Innovation" class="text-lg font-semibold text-gray-800 mb-6" />
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach(\App\Models\ref_agenda::all() as $agenda)
                                @php $checked = collect(old('agenda_addressed', $agendaSelected))->contains($agenda->agenda_code); @endphp
                                <label class="inline-flex items-center px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm cursor-pointer transition hover:bg-emerald-100 hover:shadow-md">
                                    <input type="checkbox" name="agenda_addressed[]" value="{{ $agenda->agenda_code }}" class="form-checkbox text-emerald-600 focus:ring-emerald-500 rounded" {{ $checked ? 'checked' : '' }}>
                                    <span class="ml-3 text-gray-800 font-medium text-sm">{{ $agenda->agenda_desc }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('agenda_addressed')" class="mt-2" />
                    </div>
                </div>

                <div class="w-full flex justify-center mb-6 mt-2">
                    <span class="section-header inline-flex items-center justify-center w-full px-6 py-3 rounded-xl">
                        <h3 class="text-xl font-bold text-white tracking-wide text-center w-full flex items-center justify-center gap-2">SUBJECT</h3>
                    </span>
                </div>
                <div class="form-card rounded-2xl p-8 mb-6">
                    <x-input-label for="mesh_keywords" value="MeSH Keywords" class="text-lg font-semibold text-gray-800 mb-4" />
                    <textarea id="mesh_keywords" name="mesh_keywords" rows="3" class="block w-full rounded-xl px-4 py-3 font-medium resize-y">{{ old('mesh_keywords', $healthResearch->mesh_keywords) }}</textarea>
                    <x-input-error :messages="$errors->get('mesh_keywords')" class="mt-2" />
                </div>
                <div class="form-card rounded-2xl p-8 mb-6">
                    <x-input-label for="non_mesh_keywords" value="Non-MeSH Keywords" class="text-lg font-semibold text-gray-800 mb-4" />
                    <textarea id="non_mesh_keywords" name="non_mesh_keywords" rows="3" class="block w-full rounded-xl px-4 py-3 font-medium resize-y">{{ old('non_mesh_keywords', $healthResearch->non_mesh_keywords) }}</textarea>
                    <x-input-error :messages="$errors->get('non_mesh_keywords')" class="mt-2" />
                </div>
            </form>
        </div>

        <div class="sticky bottom-0 z-10 -mx-12 px-12 py-6 bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/70 border-t border-gray-200 flex items-center justify-end gap-4 mt-12">
            <a href="{{ route('research.health_researches.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl text-base font-medium shadow-sm transition-all duration-200 hover:shadow-md">Cancel</a>
            <button form="health-research-form" type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-8 py-3 rounded-xl text-base font-semibold shadow-lg transition-all duration-200 flex items-center gap-3 hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                Update Research
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const govRadios = document.querySelectorAll('input[name="is_gov_fund"]');
            const govFields = document.getElementById('gov-fund-fields');
            const budget = document.getElementById('budget');
            const currency = document.getElementById('currency_code');
            function syncGov() {
                const val = Array.from(govRadios).find(r => r.checked)?.value;
                const show = val === 'yes';
                if (govFields) govFields.style.display = show ? '' : 'none';
                if (budget) budget.disabled = !show;
                if (currency) currency.disabled = !show;
            }
            govRadios.forEach(r => r.addEventListener('change', syncGov));
            syncGov();

            document.querySelectorAll('[id^="enter_url_nonprint_"]').forEach(cb => {
                const idx = cb.id.split('_').pop();
                const input = document.getElementById('url_input_nonprint_' + idx);
                function sync() { if (input) input.disabled = !cb.checked; }
                cb.addEventListener('change', sync); sync();
            });
            document.querySelectorAll('[id^="upload_file_nonprint_"]').forEach(cb => {
                const idx = cb.id.split('_').pop();
                const input = document.getElementById('file_upload_nonprint_' + idx);
                function sync() { if (input) input.disabled = !cb.checked; }
                cb.addEventListener('change', sync); sync();
            });

            document.querySelectorAll('[id^="mode_of_access_print_"]').forEach(sel => {
                const idx = sel.id.split('_').pop();
                const wrap = sel.closest('.form-card').querySelector('.inst-email');
                function sync() { if (wrap) wrap.style.display = sel.value === 'Request to Institution' ? '' : 'none'; }
                sel.addEventListener('change', sync); sync();
            });

            document.querySelectorAll('[id^="format_"]').forEach(sel => {
                const card = sel.closest('.form-card');
                const print = card.querySelector('.print-fields');
                const nonprint = card.querySelector('.nonprint-fields');
                function sync() {
                    const v = sel.value;
                    if (print) print.style.display = (v === 'Print') ? '' : 'none';
                    if (nonprint) nonprint.style.display = (v === 'Non-Print') ? '' : 'none';
                }
                sel.addEventListener('change', sync); sync();
            });

            const nuhraOthersCheckbox = document.getElementById('nuhra_others_checkbox');
            const nuhraOthersInput = document.getElementById('nuhra_others_input');
            if (nuhraOthersCheckbox && nuhraOthersInput) {
                function toggleNuhraOthers() { nuhraOthersInput.style.display = nuhraOthersCheckbox.checked ? 'block' : 'none'; nuhraOthersInput.required = nuhraOthersCheckbox.checked; }
                nuhraOthersCheckbox.addEventListener('change', toggleNuhraOthers); toggleNuhraOthers();
            }
            const mthriaOthersCheckbox = document.getElementById('mthria_others_checkbox');
            const mthriaOthersInput = document.getElementById('mthria_others_input');
            if (mthriaOthersCheckbox && mthriaOthersInput) {
                function toggleMthriaOthers() { mthriaOthersInput.style.display = mthriaOthersCheckbox.checked ? 'block' : 'none'; mthriaOthersInput.required = mthriaOthersCheckbox.checked; }
                mthriaOthersCheckbox.addEventListener('change', toggleMthriaOthers); toggleMthriaOthers();
            }

            const formEl = document.getElementById('health-research-form');
            formEl.addEventListener('submit', function() {
                formEl.querySelectorAll('[style*="display: none"]').forEach(container => {
                    container.querySelectorAll('input, select, textarea').forEach(el => { el.disabled = true; el.removeAttribute('required'); });
                });
            });
        });
    </script>
</x-app-layout>


