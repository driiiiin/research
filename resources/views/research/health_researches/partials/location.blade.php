<div class="dynamic-section space-y-6 p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
    <div class="flex items-start justify-between">
        <h4 class="text-base font-semibold text-gray-800">Location {{ ($index ?? 0) + 1 }}</h4>
        <button type="button" class="text-red-600 hover:text-red-700" onclick="removeSection(this)">Remove</button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
            <x-input-label for="format_{{ $index }}" value="Format" />
            <select id="format_{{ $index }}" name="format[]" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition" onchange="toggleLocationFields(this)">
                <option value="Print" {{ old('format.' . ($index ?? 0)) == 'Print' ? 'selected' : '' }}>Print</option>
            <option value="Non-Print" {{ old('format.' . ($index ?? 0)) == 'Non-Print' ? 'selected' : '' }}>Non-Print</option>
            </select>
        </div>
        <div>
            <x-input-label for="location_name_{{ $index }}" value="Location Name" />
            <input id="location_name_{{ $index }}" type="text" name="location_name[]" value="{{ old('location_name.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
        </div>

        <div class="print-fields {{ old('format.' . ($index ?? 0)) == 'Non-Print' ? 'hidden' : '' }} lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <x-input-label for="call_number_{{ $index }}" value="Call Number" />
                <input id="call_number_{{ $index }}" type="text" name="call_number[]" value="{{ is_array(old('call_number.' . ($index ?? 0))) ? '' : old('call_number.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
            </div>
            <div>
                <x-input-label for="copy_number_{{ $index }}" value="Copy Number" />
                <input id="copy_number_{{ $index }}" type="text" name="copy_number[]" value="{{ is_array(old('copy_number.' . ($index ?? 0))) ? '' : old('copy_number.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
            </div>
            <div>
                <x-input-label for="shelf_location_{{ $index }}" value="Shelf Location" />
                <input id="shelf_location_{{ $index }}" type="text" name="shelf_location[]" value="{{ is_array(old('shelf_location.' . ($index ?? 0))) ? '' : old('shelf_location.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition">
            </div>
        </div>

        <div class="non-print-fields {{ old('format.' . ($index ?? 0)) == 'Non-Print' ? '' : 'hidden' }} lg:col-span-3">
            <x-input-label for="access_link_{{ $index }}" value="Access Link (optional)" />
            <input id="access_link_{{ $index }}" type="url" name="access_link[]" value="{{ is_array(old('access_link.' . ($index ?? 0))) ? '' : old('access_link.' . ($index ?? 0)) }}" class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition" placeholder="https://...">
        </div>
    </div>
</div>

