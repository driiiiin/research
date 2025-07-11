<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Categories Management') }}
            </h2>
            <a href="{{ route('library.categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Add New Category
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Categories Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($categories as $category)
                            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-4 h-4 rounded-full" style="background-color: {{ $category->color }};"></div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('library.categories.edit', $category) }}"
                                           class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                        <form method="POST" action="{{ route('library.categories.destroy', $category) }}"
                                              class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>

                                @if($category->description)
                                    <p class="text-gray-600 text-sm mb-4">{{ $category->description }}</p>
                                @endif

                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>{{ $category->books_count ?? 0 }} books</span>
                                    @if($category->parent)
                                        <span class="text-xs bg-gray-100 px-2 py-1 rounded">Subcategory of {{ $category->parent->name }}</span>
                                    @endif
                                </div>

                                @if($category->children->count() > 0)
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Subcategories:</h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($category->children as $child)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                                      style="background-color: {{ $child->color }}20; color: {{ $child->color }};">
                                                    {{ $child->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No categories</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new category.</p>
                                <div class="mt-6">
                                    <a href="{{ route('library.categories.create') }}"
                                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        Add Category
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
