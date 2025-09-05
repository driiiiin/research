<div class="dynamic-section space-y-6 p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
    <div class="flex items-start justify-between">
        <h4 class="text-base font-semibold text-gray-800">Author {{ ($index ?? 0) + 1 }}</h4>
        <button type="button" class="text-red-600 hover:text-red-700" onclick="removeSection(this)">Remove</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <x-input-label for="author_first_name_{{ $index }}" value="First Name" />
            <input id="author_first_name_{{ $index }}" type="text" name="author_first_name[]" value="{{ old('author_first_name.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
            <x-input-error :messages="$errors->get('author_first_name.' . ($index ?? 0))" class="mt-2" />
        </div>
        <div>
            <x-input-label for="author_middle_name_{{ $index }}" value="Middle Name (optional)" />
            <input id="author_middle_name_{{ $index }}" type="text" name="author_middle_name[]" value="{{ old('author_middle_name.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
        </div>
        <div>
            <x-input-label for="author_last_name_{{ $index }}" value="Last Name" />
            <input id="author_last_name_{{ $index }}" type="text" name="author_last_name[]" value="{{ old('author_last_name.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
            <x-input-error :messages="$errors->get('author_last_name.' . ($index ?? 0))" class="mt-2" />
        </div>
        <div class="md:col-span-3">
            <x-input-label for="author_institution_{{ $index }}" value="Institution (optional)" />
            <input id="author_institution_{{ $index }}" type="text" name="author_institution[]" value="{{ old('author_institution.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
        </div>
    </div>
</div>

