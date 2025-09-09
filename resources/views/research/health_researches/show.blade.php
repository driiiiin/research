<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight tracking-tight">
                {{ __('Health Research Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('research.health_researches.edit', $healthResearch) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit Health Research
                </a>
                <a href="{{ route('research.health_researches.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Back to Health Researches
                </a>
            </div>
        </div>
    </x-slot>
    <div class="py-10 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-white rounded-2xl shadow-xl px-10 pb-10 pt-0 space-y-10">
                <!-- TITLE Section -->
                <div class="w-full flex justify-center mb-4 mt-2">
                    <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                        <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">TITLE</h3>
                    </span>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-end gap-2">
                    <div class="sm:w-44 w-full">
                        <div class="text-lg font-semibold text-gray-800 mb-2">Accession No.</div>
                        <div class="text-lg text-gray-900">{{ $healthResearch->accession_no }}</div>
                    </div>
                    <div class="flex-1">
                        <div class="text-lg font-semibold text-gray-800 mb-2">Research Title</div>
                        <div class="text-lg text-gray-900">{{ $healthResearch->research_title }}</div>
                    </div>
                </div>
                @if(!empty($healthResearch->subtitle))
                <div class="mt-6">
                    <div class="text-lg font-semibold text-gray-800 mb-2">Subtitle</div>
                    <ul class="list-disc ml-6">
                        @foreach((is_array($healthResearch->subtitle) ? $healthResearch->subtitle : (array)json_decode($healthResearch->subtitle, true)) as $sub)
                            @if($sub)
                                <li>{{ $sub }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif
                <!-- SOURCE Section -->
                <div class="w-full flex justify-center mb-4 mt-2">
                    <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                        <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">SOURCE</h3>
                    </span>
                </div>
                <div>
                    <div class="text-lg font-semibold text-gray-800 mb-2">Date Issued</div>
                    <div class="mb-2">From: {{ $healthResearch->date_issued_from_month }}/{{ $healthResearch->date_issued_from_year }} To: {{ $healthResearch->date_issued_to_month }}/{{ $healthResearch->date_issued_to_year }}</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><span class="font-semibold">Volume No.:</span> {{ $healthResearch->volume_no }}</div>
                        <div><span class="font-semibold">Issue No.:</span> {{ $healthResearch->issue_no }}</div>
                        <div><span class="font-semibold">Pages:</span> {{ $healthResearch->pages }}</div>
                        <div><span class="font-semibold">Article No.:</span> {{ $healthResearch->article_no }}</div>
                        <div class="md:col-span-2"><span class="font-semibold">DOI:</span> {{ $healthResearch->doi }}</div>
                    </div>
                </div>
                <div>
                    <div class="text-lg font-semibold text-gray-800 mb-2">Notes</div>
                    <div class="text-lg text-gray-900">{{ $healthResearch->notes }}</div>
                </div>
                <div>
                    <div class="text-lg font-semibold text-gray-800 mb-2">Research Category</div>
                    <div>{{ $healthResearch->research_category }}</div>
                </div>
                <div>
                    <div class="text-lg font-semibold text-gray-800 mb-2">Research Type</div>
                    <div>{{ $healthResearch->research_type }}</div>
                </div>
                <!-- AUTHOR Section -->
                <div class="w-full flex justify-center mb-4 mt-2">
                    <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                        <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">AUTHOR</h3>
                    </span>
                </div>
                <div>
                    @if(isset($healthResearch->authors) && is_iterable($healthResearch->authors))
                        <ul class="list-disc ml-6">
                            @foreach($healthResearch->authors as $author)
                                <li>{{ $author->full_name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <div>{{ $healthResearch->author }}</div>
                    @endif
                </div>
                <!-- ABSTRACT Section -->
                <div class="w-full flex justify-center mb-4 mt-2">
                    <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                        <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">ABSTRACT</h3>
                    </span>
                </div>
                <div>
                    <div class="text-lg font-semibold text-gray-800 mb-2">Abstract Type</div>
                    <div>{{ $healthResearch->abstract_type }}</div>
                    <div class="text-lg font-semibold text-gray-800 mb-2 mt-4">Abstract Content</div>
                    <div class="text-lg text-gray-900">{{ $healthResearch->research_abstract }}</div>
                </div>
                <!-- REFERENCE Section -->
                <div class="w-full flex justify-center mb-4 mt-2">
                    <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                        <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">REFERENCE</h3>
                    </span>
                </div>
                <div>
                    <div class="text-lg font-semibold text-gray-800 mb-2">Reference</div>
                    <div class="text-lg text-gray-900">{{ $healthResearch->reference }}</div>
                </div>
                <!-- LOCATION Section -->
                <div class="w-full flex justify-center mb-4 mt-2">
                    <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                        <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">LOCATION</h3>
                    </span>
                </div>
                <div>
                    @if(isset($healthResearch->locations) && is_iterable($healthResearch->locations))
                        <ul class="list-disc ml-6">
                            @foreach($healthResearch->locations as $location)
                                <li>{{ $location->format }} - {{ $location->physical_location }} - {{ $location->mode_of_access }}</li>
                            @endforeach
                        </ul>
                    @else
                        <div>{{ $healthResearch->location }}</div>
                    @endif
                </div>
                <!-- SUBJECT Section -->
                <div class="w-full flex justify-center mb-4 mt-2">
                    <span class="inline-flex items-center justify-center w-full px-4 py-2 rounded-lg bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                        <h3 class="text-xl font-extrabold text-white tracking-tight text-center w-full">SUBJECT</h3>
                    </span>
                </div>
                <div>
                    <div class="text-lg font-semibold text-gray-800 mb-2">MeSH Keywords</div>
                    <div>{{ $healthResearch->mesh_keywords }}</div>
                    <div class="text-lg font-semibold text-gray-800 mb-2 mt-4">Non-MeSH Keywords</div>
                    <div>{{ $healthResearch->non_mesh_keywords }}</div>
                </div>
                <!-- Additional Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
                    <div><span class="font-semibold">SDG Addressed:</span> {{ $healthResearch->sdg_addressed }}</div>
                    <div><span class="font-semibold">Policy Brief:</span> {{ $healthResearch->policy_brief }}</div>
                    <div><span class="font-semibold">Final Report:</span> {{ $healthResearch->final_report }}</div>
                    <div><span class="font-semibold">Implementing Agency:</span> {{ $healthResearch->implementing_agency }}</div>
                    <div><span class="font-semibold">Cooperating Agency:</span> {{ $healthResearch->cooperating_agency }}</div>
                    <div><span class="font-semibold">General Note:</span> {{ $healthResearch->general_note }}</div>
                    <div><span class="font-semibold">Budget:</span> {{ $healthResearch->budget }}</div>
                    <div><span class="font-semibold">Fund Information:</span> {{ $healthResearch->fund_information }}</div>
                    <div><span class="font-semibold">Duration:</span> {{ $healthResearch->duration }}</div>
                    <div><span class="font-semibold">Start Date:</span> {{ $healthResearch->start_date }}</div>
                    <div><span class="font-semibold">End Date:</span> {{ $healthResearch->end_date }}</div>
                    <div><span class="font-semibold">Year End Date:</span> {{ $healthResearch->year_end_date }}</div>
                    <div><span class="font-semibold">Keywords:</span> {{ $healthResearch->keywords }}</div>
                    <div><span class="font-semibold">Status:</span> {{ $healthResearch->status }}</div>
                    <div><span class="font-semibold">Citation:</span> {{ $healthResearch->citation }}</div>
                    <div><span class="font-semibold">Upload Status:</span> {{ $healthResearch->upload_status }}</div>
                    <div><span class="font-semibold">Remarks:</span> {{ $healthResearch->remarks }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
