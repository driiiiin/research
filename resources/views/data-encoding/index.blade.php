<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Encoding') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Encoding Section -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Encode Data</h3>

                            <form method="POST" action="{{ route('data-encoding.encode') }}" class="space-y-4">
                                @csrf

                                <div>
                                    <x-input-label for="encoding_type" value="Encoding Type" />
                                    <select id="encoding_type" name="encoding_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="base64">Base64</option>
                                        <option value="url">URL Encoding</option>
                                        <option value="html">HTML Entities</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('encoding_type')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="data" value="Input Data" />
                                    <textarea id="data" name="data" rows="6" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Enter the data you want to encode...">{{ session('original_data') }}</textarea>
                                    <x-input-error :messages="$errors->get('data')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end">
                                    <x-primary-button>
                                        {{ __('Encode') }}
                                    </x-primary-button>
                                </div>
                            </form>

                            @if (session('encoded_data'))
                                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <h4 class="font-medium text-blue-800 mb-2">Encoded Result:</h4>
                                    <div class="bg-white p-3 rounded border">
                                        <code class="text-sm break-all">{{ session('encoded_data') }}</code>
                                    </div>
                                    <button onclick="copyToClipboard('{{ session('encoded_data') }}')" class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                                        Copy to Clipboard
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Decoding Section -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Decode Data</h3>

                            <form method="POST" action="{{ route('data-encoding.decode') }}" class="space-y-4">
                                @csrf

                                <div>
                                    <x-input-label for="decode_encoding_type" value="Encoding Type" />
                                    <select id="decode_encoding_type" name="encoding_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="base64">Base64</option>
                                        <option value="url">URL Encoding</option>
                                        <option value="html">HTML Entities</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('encoding_type')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="encoded_data" value="Encoded Data" />
                                    <textarea id="encoded_data" name="encoded_data" rows="6" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Enter the encoded data you want to decode...">{{ session('encoded_data') }}</textarea>
                                    <x-input-error :messages="$errors->get('encoded_data')" class="mt-2" />
                            </div>

                                <div class="flex items-center justify-end">
                                    <x-primary-button>
                                        {{ __('Decode') }}
                                    </x-primary-button>
                                </div>
                            </form>

                            @if (session('decoded_data'))
                                <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <h4 class="font-medium text-green-800 mb-2">Decoded Result:</h4>
                                    <div class="bg-white p-3 rounded border">
                                        <code class="text-sm break-all">{{ session('decoded_data') }}</code>
                                    </div>
                                    <button onclick="copyToClipboard('{{ session('decoded_data') }}')" class="mt-2 text-sm text-green-600 hover:text-green-800">
                                        Copy to Clipboard
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Information Section -->
                    <div class="mt-8 bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4 text-blue-800">About Data Encoding</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <h4 class="font-medium text-blue-700 mb-2">Base64 Encoding</h4>
                                <p class="text-blue-600">Converts binary data to ASCII text format. Commonly used for encoding images, files, and binary data in text-based protocols.</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-blue-700 mb-2">URL Encoding</h4>
                                <p class="text-blue-600">Converts special characters to percent-encoded format. Used for encoding data in URLs and form submissions.</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-blue-700 mb-2">HTML Entities</h4>
                                <p class="text-blue-600">Converts special characters to HTML entity format. Used for displaying special characters safely in HTML.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // You could add a toast notification here
                console.log('Copied to clipboard');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
</x-app-layout>
