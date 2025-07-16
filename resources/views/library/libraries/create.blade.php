<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Library') }}
            </h2>
            <a href="{{ route('libraries.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Back to Libraries
            </a>
        </div>
    </x-slot>

    <div>
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('libraries.store') }}" class="space-y-6">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="name" value="Library Name *" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    value="{{ old('name') }}" placeholder="e.g., National Library, City Library" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="description" value="Description" />
                                <textarea id="description" name="description" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Brief description of this library...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="location" value="Location" />
                                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
                                    value="{{ old('location') }}" placeholder="e.g., Manila, Cebu City, Davao" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="color" value="Library Color" />
                                <div class="mt-1 flex items-center space-x-2">
                                    <input type="color" id="color" name="color"
                                        value="{{ old('color', '#6366F1') }}"
                                        class="h-10 w-16 border border-gray-300 rounded-md" />
                                    <x-text-input id="color_hex" type="text" class="block w-full"
                                        value="{{ old('color', '#6366F1') }}"
                                        placeholder="#6366F1" />
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Choose a color to help identify this library.</p>
                                <x-input-error :messages="$errors->get('color')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('libraries.index') }}"
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Add Library') }}
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
