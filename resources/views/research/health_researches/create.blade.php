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

    <div class="py-10 min-h-screen" style="padding-top: 0px;">
        <div class="max-w-7xl mx-auto px-6">
            <style>
                /* Make all labels inside the form black and bold */
                #health-research-form label { color: #000 !important; font-weight: 700 !important; }
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
            </style>
            <form id="health-research-form" method="POST" action="{{ route('research.health_researches.store') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-xl px-10 pb-10 pt-0 space-y-10" data-next-accession-url="{{ route('research.health_researches.next_accession') }}">
                @csrf
                <h2 class="text-3xl font-extrabold text-emerald-800 text-center text-emerald-900">Health Research Form</h2>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
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
                                    if (["INPUT","SELECT","TEXTAREA"].includes(node.tagName)) return;
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
                    <div class="w-full flex justify-center mb-4 mt-2">
                        <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                            <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">TITLE</h3>
                        </span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-end gap-2">
                        <div class="sm:w-44 w-full">
                            <x-input-label for="accession_no" value="Accession No." class="text-lg font-semibold text-gray-800 mb-2" />
                            <input
                                type="text"
                                name="accession_no"
                                id="accession_no"
                                class="mt-1 block w-full border border-gray-300 rounded-xl px-5 text-lg focus:ring-emerald-500 focus:border-emerald-500 transition bg-gray-50 shadow-sm"
                                style="height: 44px; min-height: 44px; padding-top: 6px; padding-bottom: 6px;"
                                placeholder="Loading..."
                                value=""
                                readonly
                                required
                            >
                        </div>
                        <div class="flex-1">
                            <x-input-label for="research_title" value="Research Title" class="text-lg font-semibold text-gray-800 mb-2" />
                            <textarea name="research_title" id="research_title"
                                class="mt-1 block w-full border border-gray-300 rounded-xl px-5 text-lg focus:ring-emerald-500 focus:border-emerald-500 transition bg-gray-50 shadow-sm resize-y"
                                maxlength="500"
                                style="height:44px; min-height:44px; max-height:180px; padding-top:10px; padding-bottom:10px;"
                                placeholder="Enter research title (up to 500 characters)">{{ old('research_title') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6">
                        <x-input-label value="Subtitle" class="text-lg font-semibold text-gray-800 mb-2" />
                        <div id="subtitles-container" class="space-y-4">
                            @php $oldSubtitles = old('subtitle'); if (!is_array($oldSubtitles)) $oldSubtitles = []; @endphp
                            @if(is_array($oldSubtitles) && count($oldSubtitles))
                            @foreach($oldSubtitles as $i => $sub)
                            <div class="flex items-center gap-4">
                                <textarea name="subtitle[]"
                                    class="flex-1 border border-gray-300 rounded-xl px-5 text-lg focus:ring-emerald-500 focus:border-emerald-500 transition bg-gray-50 shadow-sm resize-y"
                                    maxlength="500"
                                    style="height:44px; min-height:44px; max-height:180px; padding-top:10px; padding-bottom:10px;"
                                    placeholder="Enter research subtitle (up to 500 characters)">{{ is_string($sub) ? $sub : '' }}</textarea>
                                @if($i > 0)
                                <button type="button" class="text-red-600 hover:text-red-700 px-4 py-2 rounded-lg bg-red-50 font-medium transition" onclick="this.parentElement.remove()">Remove</button>
                                @endif
                            </div>
                            @endforeach
                            @else
                            <div class="flex items-center gap-4">
                                <textarea name="subtitle[]"
                                    class="flex-1 border border-gray-300 rounded-xl px-5 text-lg focus:ring-emerald-500 focus:border-emerald-500 transition bg-gray-50 shadow-sm resize-y"
                                    maxlength="500"
                                    style="height:44px; min-height:44px; max-height:180px; padding-top:10px; padding-bottom:10px;"
                                    placeholder="Enter research subtitle (up to 500 characters)"></textarea>
                            </div>
                            @endif
                        </div>
                        <button type="button" id="add-subtitle" class="mt-3 text-emerald-700 text-base font-semibold hover:underline transition">+ Add Subtitle</button>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.getElementById('add-subtitle').addEventListener('click', function() {
                                const container = document.getElementById('subtitles-container');
                                const div = document.createElement('div');
                                div.className = 'flex items-center gap-4';
                                div.innerHTML = `
                                    <textarea name="subtitle[]"
                                        class="flex-1 border border-gray-300 rounded-xl px-5 text-lg focus:ring-emerald-500 focus:border-emerald-500 transition bg-gray-50 shadow-sm resize-y"
                                        maxlength="500"
                                        style="height:44px; min-height:44px; max-height:180px; padding-top:10px; padding-bottom:10px;"
                                        placeholder="Enter research subtitle (up to 500 characters)"></textarea>
                                    <button type="button" class="text-red-600 hover:text-red-700 px-4 py-2 rounded-lg bg-red-50 font-medium transition" onclick="this.parentElement.remove()">Remove</button>
                                `;
                                container.appendChild(div);
                            });
                        });
                    </script>
                    <!-- Source Section -->
                    <div class="w-full flex justify-center mb-4 mt-2">
                        <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                            <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">SOURCE</h3>
                        </span>
                    </div>

                    <!-- Date Issued -->
                    <div>
                        <x-input-label value="Date Issued *" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            <div>
                                <x-input-label for="date_issued_from_month" value="From" class="sr-only" />
                                <select id="date_issued_from_month" name="date_issued_from_month" class="block w-full border-gray-300 rounded-md" required>
                                    <option value="">Month</option>
                                    @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $i => $month)
                                    <option value="{{ $i+1 }}" {{ old('date_issued_from_month') == $i+1 ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="date_issued_from_year" value="Year" class="sr-only" />
                                <x-text-input id="date_issued_from_year" name="date_issued_from_year" type="number" class="block w-full border-gray-300 rounded-md" min="1970" max="2025" value="{{ old('date_issued_from_year') }}" required placeholder="Year" />
                            </div>
                            <span class="self-center px-2">to</span>
                            <div>
                                <x-input-label for="date_issued_to_month" value="To" class="sr-only" />
                                <select id="date_issued_to_month" name="date_issued_to_month" class="block w-full border-gray-300 rounded-md" required>
                                    <option value="">Month</option>
                                    @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $i => $month)
                                    <option value="{{ $i+1 }}" {{ old('date_issued_to_month') == $i+1 ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="date_issued_to_year" value="Year" class="sr-only" />
                                <x-text-input id="date_issued_to_year" name="date_issued_to_year" type="number" class="block w-full border-gray-300 rounded-md" min="1970" max="2025" value="{{ old('date_issued_to_year') }}" required placeholder="Year" />
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('date_issued_from_month')" class="mt-2" />
                        <x-input-error :messages="$errors->get('date_issued_from_year')" class="mt-2" />
                        <x-input-error :messages="$errors->get('date_issued_to_month')" class="mt-2" />
                        <x-input-error :messages="$errors->get('date_issued_to_year')" class="mt-2" />
                    </div>

                    <!-- Publication Details -->
                    <div>
                        <x-input-label value="Publication Details" />
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="volume_no" value="Volume No. *" />
                                <x-text-input id="volume_no" name="volume_no" type="text" class="mt-1 block w-full" value="{{ old('volume_no') }}" required />
                                <x-input-error :messages="$errors->get('volume_no')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="issue_no" value="Issue No." />
                                <x-text-input id="issue_no" name="issue_no" type="text" class="mt-1 block w-full" value="{{ old('issue_no') }}" />
                                <x-input-error :messages="$errors->get('issue_no')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="pages" value="Page(s)" />
                                <x-text-input id="pages" name="pages" type="text" class="mt-1 block w-full" value="{{ old('pages') }}" />
                                <x-input-error :messages="$errors->get('pages')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="article_no" value="Article No." />
                                <x-text-input id="article_no" name="article_no" type="text" class="mt-1 block w-full" value="{{ old('article_no') }}" />
                                <x-input-error :messages="$errors->get('article_no')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="doi" value="DOI" />
                                <x-text-input id="doi" name="doi" type="text" class="mt-1 block w-full" value="{{ old('doi') }}" />
                                <x-input-error :messages="$errors->get('doi')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <x-input-label for="notes" value="Notes" />
                        <textarea
                            id="notes"
                            name="notes"
                            rows="4"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            placeholder="Enter any additional notes here...">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <!-- Research Category -->
                    <div>
                        <x-input-label value="Research Category *" />
                        <div class="flex flex-wrap gap-6 mt-1">
                            <label class="inline-flex items-center">
                                <input type="radio" name="research_category" value="Institutional" {{ old('research_category') == 'Institutional' ? 'checked' : '' }} required class="form-radio text-orange-500" x-ref="research_category" />
                                <span class="ml-2">Institutional</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="research_category" value="Collaborative" {{ old('research_category') == 'Collaborative' ? 'checked' : '' }} required class="form-radio text-orange-500" x-ref="research_category" />
                                <span class="ml-2">Collaborative</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="research_category" value="Commissioned" {{ old('research_category') == 'Commissioned' ? 'checked' : '' }} required class="form-radio text-orange-500" x-ref="research_category" />
                                <span class="ml-2">Commissioned</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('research_category')" class="mt-2" />
                    </div>

                    <!-- Research Type -->
                    <div>
                        <x-input-label value="Research Type *" />
                        <div class="flex flex-wrap gap-6 mt-1">
                            <label class="inline-flex items-center">
                                <input type="radio" name="research_type" value="Basic" {{ old('research_type') == 'Basic' ? 'checked' : '' }} required class="form-radio text-orange-500" x-ref="research_type" />
                                <span class="ml-2">Basic</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="research_type" value="Applied" {{ old('research_type') == 'Applied' ? 'checked' : '' }} required class="form-radio text-orange-500" x-ref="research_type" />
                                <span class="ml-2">Applied</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="research_type" value="Experimental" {{ old('research_type') == 'Experimental' ? 'checked' : '' }} required class="form-radio text-orange-500" x-ref="research_type" />
                                <span class="ml-2">Experimental</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('research_type')" class="mt-2" />
                    </div>

                    <!-- Author Details Section -->
                    <div class="w-full flex justify-center mb-4 mt-2">
                        <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                            <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">AUTHOR</h3>
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
                            <div class="border border-gray-200 rounded-lg shadow bg-white">
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                        <div>
                                            <x-input-label for="author_last_name" value="Last Name" class="text-lg font-semibold text-gray-800 mb-2" />
                                            <input id="author_last_name" name="author_last_name[]" type="text" class="mt-1 block w-full border border-gray-300 rounded-xl px-5 text-lg focus:ring-emerald-500 focus:border-emerald-500 transition bg-gray-50 shadow-sm" style="height: 44px; min-height: 44px; padding-top: 6px; padding-bottom: 6px;" placeholder="Enter last name" />
                                            <x-input-error :messages="$errors->get('author_last_name.*')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="author_first_name" value="First Name" class="text-lg font-semibold text-gray-800 mb-2" />
                                            <input id="author_first_name" name="author_first_name[]" type="text" class="mt-1 block w-full border border-gray-300 rounded-xl px-5 text-lg focus:ring-emerald-500 focus:border-emerald-500 transition bg-gray-50 shadow-sm" style="height: 44px; min-height: 44px; padding-top: 6px; padding-bottom: 6px;" placeholder="Enter first name" />
                                            <x-input-error :messages="$errors->get('author_first_name.*')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="author_middle_name" value="Middle Name" class="text-lg font-semibold text-gray-800 mb-2" />
                                            <input id="author_middle_name" name="author_middle_name[]" type="text" class="mt-1 block w-full border border-gray-300 rounded-xl px-5 text-lg focus:ring-emerald-500 focus:border-emerald-500 transition bg-gray-50 shadow-sm" style="height: 44px; min-height: 44px; padding-top: 6px; padding-bottom: 6px;" placeholder="Enter middle name" />
                                            <x-input-error :messages="$errors->get('author_middle_name.*')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="author_suffix" value="Suffix" class="text-lg font-semibold text-gray-800 mb-2" />
                                            <select id="author_suffix" name="author_suffix[]" class="mt-1 block w-full border border-gray-300 rounded-xl px-5 text-lg focus:ring-emerald-500 focus:border-emerald-500 transition bg-gray-50 shadow-sm" style="height: 44px; min-height: 44px; padding-top: 6px; padding-bottom: 6px;">
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
                                    <div class="flex justify-end mt-4">
                                        <button
                                            type="button"
                                            @click="removeAuthorForm(index)"
                                            x-show="authorForms.length > 1"
                                            class="w-7 h-7 bg-red-500 text-white rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 flex items-center justify-center"
                                            title="Remove Author">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="flex justify-end mt-4">
                            <button type="button" @click="addAuthorForm()" class="w-8 h-8 bg-orange-500 text-white rounded-full hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 flex items-center justify-center" title="Add Author">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Abstract Section -->
                    <div class="w-full flex justify-center mb-4 mt-2">
                        <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                            <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">ABSTRACT</h3>
                        </span>
                    </div>

                    <div class="border border-gray-200 rounded-lg shadow bg-white">
                        <div class="p-6">
                            <div class="mb-4">
                                <x-input-label for="abstract_type" value="Abstract Type" class="text-lg font-semibold text-gray-800 mb-2" />
                                <select id="abstract_type" name="abstract_type" class="mt-1 block w-full border border-gray-300 rounded-xl px-5 text-lg focus:ring-blue-500 focus:border-blue-500 transition bg-gray-50 shadow-sm" style="height: 44px; min-height: 44px; padding-top: 6px; padding-bottom: 6px;">
                                    <option value="Full Abstract" selected>Full Abstract</option>
                                </select>
                                <x-input-error :messages="$errors->get('abstract_type')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="research_abstract" value="Abstract Content" class="text-lg font-semibold text-gray-800 mb-2" />
                                <textarea id="research_abstract" name="research_abstract" rows="8" class="mt-1 block w-full border border-gray-300 rounded-xl px-5 text-lg focus:ring-blue-500 focus:border-blue-500 transition bg-gray-50 shadow-sm resize-y" placeholder="Enter your research abstract here...">{{ old('research_abstract') }}</textarea>
                                <x-input-error :messages="$errors->get('research_abstract')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Reference Section -->
                    <div class="w-full flex justify-center mb-4 mt-2">
                        <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                            <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">REFERENCE</h3>
                        </span>
                    </div>

                    <div>
                        <x-input-label for="reference" value="Reference" class="text-lg font-semibold text-gray-800 mb-2" />
                        <textarea id="reference" name="reference" rows="6" class="mt-1 block w-full border border-gray-300 rounded-xl px-5 text-lg focus:ring-emerald-500 focus:border-emerald-500 transition bg-gray-50 shadow-sm resize-y" placeholder="Enter your references here...">{{ old('reference') }}</textarea>
                        <x-input-error :messages="$errors->get('reference')" class="mt-2" />
                    </div>

                    <!-- Location Section -->
                    <div class="w-full flex justify-center mb-4 mt-2">
                        <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                            <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">LOCATION</h3>
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
                            <div class="border border-gray-200 rounded-lg shadow bg-white">
                                <div class="p-6">
                                    <div class="flex justify-end mb-4">
                                        <button
                                            type="button"
                                            @click="removeLocationForm(index)"
                                            x-show="locationForms.length > 1"
                                            class="w-7 h-7 bg-red-500 text-white rounded-full hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 flex items-center justify-center"
                                            title="Remove Location">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-gray-600 italic mb-4">Please input the location where the material can be viewed or access.</p>

                                <!-- Format Selection -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <x-input-label for="format" value="Format *" />
                                        <select id="format" name="format[]" x-model="form.format" x-ref="format" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
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

                                    <!-- Location Number and Text Availability -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <x-input-label for="location_number_print" value="Location Number" />
                                            <x-text-input id="location_number_print" name="location_number[]" type="text" class="mt-1 block w-full" value="{{ is_array(old('location_number.0')) ? '' : old('location_number.0') }}" />
                                            <x-input-error :messages="$errors->get('location_number.*')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="text_availability_print" value="Text Availability *" />
                                            <select id="text_availability_print" name="text_availability[]" x-ref="text_availability" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-bind:required="form.format === 'Print'">
                                                <option value="">Select Text Availability</option>
                                                <option value="Abstract Only" {{ (is_array(old('text_availability.0')) ? '' : old('text_availability.0')) == 'Abstract Only' ? 'selected' : '' }}>Abstract Only</option>
                                                <option value="Full-text" {{ (is_array(old('text_availability.0')) ? '' : old('text_availability.0')) == 'Full-text' ? 'selected' : '' }}>Full-text</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('text_availability.*')" class="mt-2" />
                                        </div>
                                    </div>

                                    <!-- Mode of Access and Institutional Email -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <x-input-label for="mode_of_access_print" value="Mode of Access *" />
                                            <select id="mode_of_access_print" name="mode_of_access[]" x-model="form.mode_of_access" x-ref="mode_of_access" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-bind:required="form.format === 'Print'">
                                                <option value="">Select Mode of Access</option>
                                                <option value="Request to Institution" {{ (is_array(old('mode_of_access.0')) ? '' : old('mode_of_access.0')) == 'Request to Institution' ? 'selected' : '' }}>Request to Institution</option>
                                                <option value="Room use Only" {{ (is_array(old('mode_of_access.0')) ? '' : old('mode_of_access.0')) == 'Room use Only' ? 'selected' : '' }}>Room use Only</option>
                                                <option value="Not available to the public" {{ (is_array(old('mode_of_access.0')) ? '' : old('mode_of_access.0')) == 'Not available to the public' ? 'selected' : '' }}>Not available to the public</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('mode_of_access.*')" class="mt-2" />
                                        </div>
                                        <div x-show="form.mode_of_access === 'Request to Institution'">
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
                                                <x-text-input type="url" name="url[]" class="flex-1 ml-2" value="{{ is_array(old('url.0')) ? '' : old('url.0') }}" placeholder="https://example.com" />
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <input type="checkbox" id="upload_file_nonprint" name="upload_file[]" value="1" {{ (is_array(old('upload_file.0')) ? '' : old('upload_file.0')) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <label for="upload_file_nonprint" class="text-sm text-blue-900">Upload File</label>
                                                <input type="file" name="file[]" class="flex-1 ml-2 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text Availability and Mode of Access for Non-Print -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <div>
                                            <x-input-label for="text_availability_nonprint" value="Text Availability *" />
                                            <select id="text_availability_nonprint" name="text_availability[]" x-ref="text_availability" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-bind:required="form.format === 'Non-Print'">
                                                <option value="">Select Text Availability</option>
                                                <option value="Abstract Only" {{ (is_array(old('text_availability.0')) ? '' : old('text_availability.0')) == 'Abstract Only' ? 'selected' : '' }}>Abstract Only</option>
                                                <option value="Full-text" {{ (is_array(old('text_availability.0')) ? '' : old('text_availability.0')) == 'Full-text' ? 'selected' : '' }}>Full-text</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('text_availability.*')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="mode_of_access_nonprint" value="Mode of Access" />
                                            <select id="mode_of_access_nonprint" name="mode_of_access[]" x-ref="mode_of_access" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="">Select Mode of Access</option>
                                                <option value="Online Request" {{ (is_array(old('mode_of_access.0')) ? '' : old('mode_of_access.0')) === 'Online Request' ? 'selected' : '' }}>Online Request</option>
                                                <option value="Publicly accessible" {{ (is_array(old('mode_of_access.0')) ? '' : old('mode_of_access.0')) === 'Publicly accessible' ? 'selected' : '' }}>Publicly accessible</option>
                                                <option value="Not available to the public" {{ (is_array(old('mode_of_access.0')) ? '' : old('mode_of_access.0')) === 'Not available to the public' ? 'selected' : '' }}>Not available to the public</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('mode_of_access.*')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </template>
                        <div class="flex justify-end mt-4">
                            <button type="button" @click="addLocationForm()" class="w-8 h-8 bg-orange-500 text-white rounded-full hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 flex items-center justify-center" title="Add Location">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- Subject Section -->
                    <div class="w-full flex justify-center mb-4 mt-2">
                        <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                            <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">SUBJECT</h3>
                        </span>
                    </div>
                    <div class="mb-6">
                        <x-input-label for="mesh_keywords" value="MeSH Keywords" class="text-lg font-semibold text-gray-800 mb-2" />
                        <div class="flex items-center space-x-2 mb-2">
                            <input type="text" id="mesh_keywords_input" name="mesh_keywords_input" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" placeholder="Add MeSH keyword" />
                            <button type="button" id="add_mesh_keyword" class="w-8 h-8 bg-orange-500 text-white rounded-full hover:bg-orange-600 flex items-center justify-center" title="Add MeSH Keyword">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <div id="mesh_keywords_chips" class="block w-full border border-gray-300 rounded-lg px-3 py-3 min-h-[120px] focus-within:ring-emerald-500 focus-within:border-emerald-500 transition flex flex-wrap items-start content-start gap-2 bg-white"></div>
                        <textarea id="mesh_keywords" name="mesh_keywords" rows="3" class="hidden">{{ is_array(old('mesh_keywords')) ? implode('; ', old('mesh_keywords')) : old('mesh_keywords') }}</textarea>
                        <x-input-error :messages="$errors->get('mesh_keywords')" class="mt-2" />
                    </div>
                    <div class="mb-6">
                        <x-input-label for="non_mesh_keywords" value="Non-MeSH Keywords" class="text-lg font-semibold text-gray-800 mb-2" />
                        <div class="flex items-center space-x-2 mb-2">
                            <input type="text" id="non_mesh_keywords_input" name="non_mesh_keywords_input" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" placeholder="Add Non-MeSH keyword" />
                            <button type="button" id="add_non_mesh_keyword" class="w-8 h-8 bg-orange-500 text-white rounded-full hover:bg-orange-600 flex items-center justify-center" title="Add Non-MeSH Keyword">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <div id="non_mesh_keywords_chips" class="block w-full border border-gray-300 rounded-lg px-3 py-3 min-h-[120px] focus-within:ring-emerald-500 focus-within:border-emerald-500 transition flex flex-wrap items-start content-start gap-2 bg-white"></div>
                        <textarea id="non_mesh_keywords" name="non_mesh_keywords" rows="3" class="hidden">{{ is_array(old('non_mesh_keywords')) ? implode('; ', old('non_mesh_keywords')) : old('non_mesh_keywords') }}</textarea>
                        <x-input-error :messages="$errors->get('non_mesh_keywords')" class="mt-2" />
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
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
                                renderChips(meshChips, meshList, (idx) => { meshList.splice(idx, 1); syncMesh(); });
                            }
                            syncMesh();
                            document.getElementById('add_mesh_keyword')?.addEventListener('click', function () {
                                const val = meshInput.value.trim();
                                if (!val) return;
                                meshList.push(val);
                                meshInput.value = '';
                                syncMesh();
                            });
                            meshInput?.addEventListener('keydown', function(e){
                                if (e.key === 'Enter') { e.preventDefault(); document.getElementById('add_mesh_keyword').click(); }
                            });

                            // Non-MeSH
                            const nonMeshInput = document.getElementById('non_mesh_keywords_input');
                            const nonMeshTextarea = document.getElementById('non_mesh_keywords');
                            const nonMeshChips = document.getElementById('non_mesh_keywords_chips');
                            let nonMeshList = parseKeywords(nonMeshTextarea.value || '');
                            function syncNonMesh() {
                                nonMeshTextarea.value = serializeKeywords(nonMeshList);
                                renderChips(nonMeshChips, nonMeshList, (idx) => { nonMeshList.splice(idx, 1); syncNonMesh(); });
                            }
                            syncNonMesh();
                            document.getElementById('add_non_mesh_keyword')?.addEventListener('click', function () {
                                const val = nonMeshInput.value.trim();
                                if (!val) return;
                                nonMeshList.push(val);
                                nonMeshInput.value = '';
                                syncNonMesh();
                            });
                            nonMeshInput?.addEventListener('keydown', function(e){
                                if (e.key === 'Enter') { e.preventDefault(); document.getElementById('add_non_mesh_keyword').click(); }
                            });
                        });
                    </script>
                    <!-- <div>
                        <x-input-label for="statement_245c" value="Statement of responsibility" />
                        <input type="text" name="statement_245c" id="statement_245c" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('statement_245c') }}">
                    </div> -->
                    <!-- <div>
                        <x-input-label for="research_title_url" value="Research Title (URL)" />
                        <input type="url" name="research_title_url" id="research_title_url" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('research_title_url') }}">
                    </div> -->
                    <div>
                        <x-input-label for="sdg_addressed" value="SDG Addressed" />
                        <input type="text" name="sdg_addressed" id="sdg_addressed" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('sdg_addressed') }}">
                    </div>
                    <!-- <div>
                        <x-input-label for="principal_investigator" value="Principal Investigator/ Main Author Inverted Name [Last Name, First Name MI]" />
                        <input type="text" name="principal_investigator" id="principal_investigator" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('principal_investigator') }}">
                    </div> -->
                    <!-- <div>
                        <x-input-label for="co_authors" value="Co-Authors Inverted Name" />
                        <textarea name="co_authors" id="co_authors" rows="2" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" placeholder="Separate multiple authors with a semicolon (;)">{{ old('co_authors') }}</textarea>
                    </div> -->
                    <!-- <div class="lg:col-span-3">
                        <x-input-label for="abstract_520a" value="Abstract" />
                        <textarea name="abstract_520a" id="abstract_520a" rows="4" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition">{{ old('abstract_520a') }}</textarea>
                    </div> -->
                    <div>
                        <x-input-label for="policy_brief" value="Policy Brief" />
                        <input type="text" name="policy_brief" id="policy_brief" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('policy_brief') }}">
                    </div>
                    <div>
                        <x-input-label for="final_report" value="Final Report" />
                        <input type="text" name="final_report" id="final_report" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('final_report') }}">
                    </div>
                    <div>
                        <x-input-label for="implementing_agency" value="Implementing Agency" />
                        <input type="text" name="implementing_agency" id="implementing_agency" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('implementing_agency') }}">
                    </div>
                    <div>
                        <x-input-label for="cooperating_agency" value="Cooperating Agency" />
                        <input type="text" name="cooperating_agency" id="cooperating_agency" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('cooperating_agency') }}">
                    </div>
                    <div>
                        <x-input-label for="general_note" value="General Note" />
                        <input type="text" name="general_note" id="general_note" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('general_note') }}">
                    </div>
                    <div>
                        <x-input-label for="budget" value="Budget" />
                        <input type="text" name="budget" id="budget" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('budget') }}">
                    </div>
                    <div>
                        <x-input-label for="fund_information" value="Fund Information" />
                        <input type="text" name="fund_information" id="fund_information" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('fund_information') }}">
                    </div>
                    <div>
                        <x-input-label for="duration" value="Duration" />
                        <input type="text" name="duration" id="duration" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('duration') }}">
                    </div>
                    <div>
                        <x-input-label for="start_date" value="Start Date" />
                        <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('start_date') }}">
                    </div>
                    <div>
                        <x-input-label for="end_date" value="End Date" />
                        <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('end_date') }}">
                    </div>
                    <div>
                        <x-input-label for="year_end_date" value="Year End Date" />
                        <input type="text" name="year_end_date" id="year_end_date" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('year_end_date') }}">
                    </div>
                    <div>
                        <x-input-label for="keywords" value="Keywords" />
                        <input type="text" name="keywords" id="keywords" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('keywords') }}">
                    </div>
                    <div>
                        <x-input-label for="status" value="Status" />
                        <input type="text" name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('status') }}">
                    </div>
                    <div>
                        <x-input-label for="citation" value="Citation" />
                        <input type="text" name="citation" id="citation" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition" value="{{ old('citation') }}">
                    </div>
                    <div>
                        <x-input-label for="upload_status" value="Upload Status" />
                        <select name="upload_status" id="upload_status" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                            <option value="">Select Status</option>
                            <option value="Uploaded" {{ old('upload_status') == 'Uploaded' ? 'selected' : '' }}>Uploaded</option>
                            <option value="Not Uploaded" {{ old('upload_status') == 'Not Uploaded' ? 'selected' : '' }}>Not Uploaded</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="remarks" value="Remarks" />
                        <textarea name="remarks" id="remarks" rows="2" class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500 transition">{{ old('remarks') }}</textarea>
                    </div>
                </div>
        </div>

        <div class="sticky bottom-0 z-10 -mx-10 px-10 py-4 bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/60 border-t border-gray-200 flex items-center justify-end gap-3 mt-8">
            <a href="{{ route('research.health_researches.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-base font-medium shadow-sm transition">
                Cancel
            </a>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg text-base font-semibold shadow-md transition flex items-center gap-2">
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
                // Remove required attributes from hidden fields
                const hiddenRequiredFields = formEl.querySelectorAll('[x-show]:not([style*="display: none"]) [required]');
                hiddenRequiredFields.forEach(field => {
                    if (field.closest('[x-show]').style.display === 'none') {
                        field.removeAttribute('required');
                    }
                });
            });
        });
    </script>
</x-app-layout>
