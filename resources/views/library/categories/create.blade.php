<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Category') }}
            </h2>
            <a href="{{ route('library.categories.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Back to Categories
            </a>
        </div>
    </x-slot>

    <div>
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('library.categories.store') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="name" value="Category Name *" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    value="{{ old('name') }}" placeholder="e.g., Fiction, Science, History" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" value="Description" />
                                <textarea id="description" name="description" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="parent_id" value="Parent Category" />
                                <select id="parent_id" name="parent_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">No Parent (Top Level)</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-sm text-gray-500">Select a parent category to create a subcategory.</p>
                                <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="color" value="Category Color" />
                                <div class="mt-1 flex items-center space-x-2">
                                    <input type="color" id="color" name="color"
                                        value="{{ old('color', '#3B82F6') }}"
                                        class="h-10 w-16 border border-gray-300 rounded-md" />
                                    <x-text-input id="color_hex" type="text" class="block w-full"
                                        value="{{ old('color', '#3B82F6') }}"
                                        placeholder="#3B82F6" />
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Choose a color to help identify this category.</p>
                                <x-input-error :messages="$errors->get('color')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Category Examples -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-800 mb-2">Category Examples</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-medium text-gray-700">Fiction</h4>
                                    <ul class="mt-1 space-y-1">
                                        <li>• Romance</li>
                                        <li>• Mystery</li>
                                        <li>• Science Fiction</li>
                                        <li>• Fantasy</li>
                                    </ul>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-700">Non-Fiction</h4>
                                    <ul class="mt-1 space-y-1">
                                        <li>• History</li>
                                        <li>• Science</li>
                                        <li>• Self-Help</li>
                                        <li>• Business</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('library.categories.index') }}"
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Add Category') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sync color picker with text input
        document.getElementById('color').addEventListener('input', function(e) {
            document.getElementById('color_hex').value = e.target.value;
        });

        document.getElementById('color_hex').addEventListener('input', function(e) {
            document.getElementById('color').value = e.target.value;
        });
    </script>
</x-app-layout>
