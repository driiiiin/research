<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Book') }}
            </h2>
            <a href="{{ route('library.books.show', $book) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Back to Book
            </a>
        </div>
    </x-slot>

    <div>
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('library.books.update', $book) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Basic Information</h3>

                                <div>
                                    <x-input-label for="title" value="Title *" />
                                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                        value="{{ old('title', $book->title) }}" required />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="author" value="Author *" />
                                    <x-text-input id="author" name="author" type="text" class="mt-1 block w-full"
                                        value="{{ old('author', $book->author) }}" required />
                                    <x-input-error :messages="$errors->get('author')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="isbn" value="ISBN" />
                                    <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full"
                                        value="{{ old('isbn', $book->isbn) }}" placeholder="e.g., 978-0-123456-47-2" />
                                    <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="publisher" value="Publisher" />
                                    <x-text-input id="publisher" name="publisher" type="text" class="mt-1 block w-full"
                                        value="{{ old('publisher', $book->publisher) }}" />
                                    <x-input-error :messages="$errors->get('publisher')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="publication_year" value="Publication Year" />
                                    <x-text-input id="publication_year" name="publication_year" type="number"
                                        class="mt-1 block w-full" value="{{ old('publication_year', $book->publication_year) }}"
                                        min="1800" max="{{ date('Y') + 1 }}" />
                                    <x-input-error :messages="$errors->get('publication_year')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="edition" value="Edition" />
                                    <x-text-input id="edition" name="edition" type="text" class="mt-1 block w-full"
                                        value="{{ old('edition', $book->edition) }}" placeholder="e.g., 1st Edition" />
                                    <x-input-error :messages="$errors->get('edition')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Additional Information</h3>

                                <div>
                                    <x-input-label for="genre" value="Genre" />
                                    <x-text-input id="genre" name="genre" type="text" class="mt-1 block w-full"
                                        value="{{ old('genre', $book->genre) }}" placeholder="e.g., Fiction, Science, History" />
                                    <x-input-error :messages="$errors->get('genre')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="language" value="Language *" />
                                    <x-text-input id="language" name="language" type="text" class="mt-1 block w-full"
                                        value="{{ old('language', $book->language) }}" />
                                    <x-input-error :messages="$errors->get('language')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="pages" value="Number of Pages" />
                                    <x-text-input id="pages" name="pages" type="number" class="mt-1 block w-full"
                                        value="{{ old('pages', $book->pages) }}" min="1" />
                                    <x-input-error :messages="$errors->get('pages')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="format" value="Format *" />
                                    <select id="format" name="format" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="Paperback" {{ old('format', $book->format) === 'Paperback' ? 'selected' : '' }}>Paperback</option>
                                        <option value="Hardcover" {{ old('format', $book->format) === 'Hardcover' ? 'selected' : '' }}>Hardcover</option>
                                        <option value="E-book" {{ old('format', $book->format) === 'E-book' ? 'selected' : '' }}>E-book</option>
                                        <option value="Audiobook" {{ old('format', $book->format) === 'Audiobook' ? 'selected' : '' }}>Audiobook</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('format')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="price" value="Price" />
                                    <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full"
                                        value="{{ old('price', $book->price) }}" min="0" placeholder="0.00" />
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="category_id" value="Category" />
                                    <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Inventory Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Inventory Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="total_copies" value="Total Copies *" />
                                    <x-text-input id="total_copies" name="total_copies" type="number" class="mt-1 block w-full"
                                        value="{{ old('total_copies', $book->total_copies) }}" min="1" required />
                                    <x-input-error :messages="$errors->get('total_copies')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="available_copies" value="Available Copies *" />
                                    <x-text-input id="available_copies" name="available_copies" type="number" class="mt-1 block w-full"
                                        value="{{ old('available_copies', $book->available_copies) }}" min="0" required />
                                    <x-input-error :messages="$errors->get('available_copies')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="status" value="Status *" />
                                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="Available" {{ old('status', $book->status) === 'Available' ? 'selected' : '' }}>Available</option>
                                        <option value="Maintenance" {{ old('status', $book->status) === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="Lost" {{ old('status', $book->status) === 'Lost' ? 'selected' : '' }}>Lost</option>
                                        <option value="Reserved" {{ old('status', $book->status) === 'Reserved' ? 'selected' : '' }}>Reserved</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="location" value="Location" />
                                    <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
                                        value="{{ old('location', $book->location) }}" placeholder="e.g., Shelf A, Row 3" />
                                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="call_number" value="Call Number" />
                                    <x-text-input id="call_number" name="call_number" type="text" class="mt-1 block w-full"
                                        value="{{ old('call_number', $book->call_number) }}" placeholder="e.g., FIC ROW" />
                                    <x-input-error :messages="$errors->get('call_number')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Description</h3>

                            <div>
                                <x-input-label for="description" value="Description" />
                                <textarea id="description" name="description" rows="4"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Enter a brief description of the book...">{{ old('description', $book->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('library.books.show', $book) }}"
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Book') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
