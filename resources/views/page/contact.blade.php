<x-guest-layout>
    <nav class="w-full bg-[#14543A] shadow rounded-2xl mt-4 mb-6">
        <div class="flex items-center h-16 px-6 space-x-8">
            <a href="{{ route('welcome') }}" class="text-white text-lg font-medium hover:underline">Home</a>
            <a href="{{ route('contact') }}" class="text-white text-lg font-medium hover:underline">Contact</a>
            <a href="{{ route('about') }}" class="text-white text-lg font-medium hover:underline">About</a>
        </div>
    </nav>
    <section class="max-w-4xl mx-auto mt-16 mb-8 bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold text-[#14543A] mb-2">Contact</h2>
        <p class="text-gray-700 mb-2">For inquiries, suggestions, or support, please contact us at:</p>
        <a href="mailto:library@example.com" class="text-indigo-600 hover:underline">library@example.com</a>
    </section>
</x-guest-layout>
