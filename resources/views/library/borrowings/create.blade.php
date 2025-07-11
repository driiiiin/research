<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Borrow Book') }}
            </h2>
            <a href="{{ route('library.borrowings.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Back to Borrowings
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('library.borrowings.store') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="book_id" value="Select Book *" />
                                <select id="book_id" name="book_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Choose a book...</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                            {{ $book->title }} by {{ $book->author }}
                                            ({{ $book->available_copies }} available)
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('book_id')" class="mt-2" />
                                @if($books->isEmpty())
                                    <p class="mt-2 text-sm text-red-600">No books are currently available for borrowing.</p>
                                @endif
                            </div>

                            <div>
                                <x-input-label for="user_id" value="Select User *" />
                                <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Choose a user...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="due_date" value="Due Date *" />
                                <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full"
                                    value="{{ old('due_date', date('Y-m-d', strtotime('+14 days'))) }}" required />
                                <p class="mt-1 text-sm text-gray-500">Default due date is 14 days from today.</p>
                                <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="notes" value="Notes" />
                                <textarea id="notes" name="notes" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Any additional notes about this borrowing...">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Borrowing Rules -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-blue-800 mb-2">Borrowing Rules</h3>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Books can be borrowed for up to 14 days</li>
                                <li>• Late returns may result in fines</li>
                                <li>• Only one copy of each book can be borrowed per user</li>
                                <li>• Books must be returned in good condition</li>
                            </ul>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('library.borrowings.index') }}"
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Borrow Book') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
