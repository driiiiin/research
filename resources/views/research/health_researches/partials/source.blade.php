<div class="dynamic-section space-y-6 p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
    <div class="flex items-start justify-between">
        <h4 class="text-base font-semibold text-gray-800">Source {{ ($index ?? 0) + 1 }}</h4>
        <button type="button" class="text-red-600 hover:text-red-700" onclick="removeSection(this)">Remove</button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
            <x-input-label for="publication_sub_type_{{ $index }}" value="Publication Subtype" />
            <input id="publication_sub_type_{{ $index }}" type="text" name="publication_sub_type[]" value="{{ old('publication_sub_type.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition" placeholder="e.g., Journal Article, Thesis">
            <x-input-error :messages="$errors->get('publication_sub_type.' . ($index ?? 0))" class="mt-2" />
        </div>
        <div>
            <x-input-label for="source_title_{{ $index }}" value="Source Title" />
            <input id="source_title_{{ $index }}" type="text" name="source_title[]" value="{{ old('source_title.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
            <x-input-error :messages="$errors->get('source_title.' . ($index ?? 0))" class="mt-2" />
        </div>
        <div>
            <x-input-label for="publication_year_{{ $index }}" value="Publication Year" />
            <input id="publication_year_{{ $index }}" type="number" min="1800" max="2100" name="publication_year[]" value="{{ old('publication_year.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
            <x-input-error :messages="$errors->get('publication_year.' . ($index ?? 0))" class="mt-2" />
        </div>
        <div>
            <x-input-label for="doi_{{ $index }}" value="DOI (optional)" />
            <input id="doi_{{ $index }}" type="text" name="doi[]" value="{{ old('doi.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
            <x-input-error :messages="$errors->get('doi.' . ($index ?? 0))" class="mt-2" />
        </div>
        <div class="lg:col-span-3">
            <x-input-label for="url_{{ $index }}" value="URL (optional)" />
            <input id="url_{{ $index }}" type="url" name="url[]" value="{{ old('url.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition" placeholder="https://...">
            <x-input-error :messages="$errors->get('url.' . ($index ?? 0))" class="mt-2" />
        </div>
    </div>
</div>

