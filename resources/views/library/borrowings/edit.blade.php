<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Borrowing') }}
            </h2>
            <a href="{{ route('library.borrowings.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Back to Borrowings
            </a>
        </div>
    </x-slot>

    <div>
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('library.borrowings.update', $borrowing) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="book_id" value="Book" />
                                <select id="book_id" name="book_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" disabled>
                                    <option value="{{ $borrowing->book->id }}" selected>
                                        {{ $borrowing->book->title }} by {{ $borrowing->book->author }}
                                    </option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">Book cannot be changed after borrowing is created.</p>
                            </div>

                            <div>
                                <x-input-label for="user_id" value="User" />
                                <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" disabled>
                                    <option value="{{ $borrowing->user->id }}" selected>
                                        {{ $borrowing->user->name }} ({{ $borrowing->user->email }})
                                    </option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">User cannot be changed after borrowing is created.</p>
                            </div>

                            <div>
                                <x-input-label for="due_date" value="Due Date *" />
                                <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full"
                                    value="{{ old('due_date', $borrowing->due_date->format('Y-m-d')) }}" required />
                                <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status" value="Status *" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Borrowed" {{ old('status', $borrowing->status) === 'Borrowed' ? 'selected' : '' }}>Borrowed</option>
                                    <option value="Returned" {{ old('status', $borrowing->status) === 'Returned' ? 'selected' : '' }}>Returned</option>
                                    <option value="Overdue" {{ old('status', $borrowing->status) === 'Overdue' ? 'selected' : '' }}>Overdue</option>
                                    <option value="Lost" {{ old('status', $borrowing->status) === 'Lost' ? 'selected' : '' }}>Lost</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="notes" value="Notes" />
                                <textarea id="notes" name="notes" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Any additional notes about this borrowing...">{{ old('notes', $borrowing->notes) }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Borrowing Information -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-800 mb-2">Borrowing Information</h3>
                            <dl class="grid grid-cols-1 gap-2 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Borrowed Date:</dt>
                                    <dd class="text-gray-900">{{ $borrowing->borrowed_at->format('M d, Y') }}</dd>
                                </div>
                                @if($borrowing->returned_at)
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Returned Date:</dt>
                                        <dd class="text-gray-900">{{ $borrowing->returned_at->format('M d, Y') }}</dd>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <dt class="text-gray-600">Days Remaining:</dt>
                                    <dd class="text-gray-900">
                                        @php
                                            $daysRemaining = now()->diffInDays($borrowing->due_date, false);
                                        @endphp
                                        @if($daysRemaining > 0)
                                            <span class="text-green-600">{{ $daysRemaining }} days</span>
                                        @elseif($daysRemaining < 0)
                                            <span class="text-red-600">{{ abs($daysRemaining) }} days overdue</span>
                                        @else
                                            <span class="text-yellow-600">Due today</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('library.borrowings.index') }}"
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Borrowing') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
