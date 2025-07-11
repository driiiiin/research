<x-guest-layout>
    <nav class="w-full bg-[#14543A] shadow rounded-2xl mt-4 mb-6">
        <div class="flex items-center h-16 px-6 space-x-8">
            <a href="{{ route('welcome') }}" class="text-white text-lg font-medium hover:underline">Home</a>
            <a href="{{ route('contact') }}" class="text-white text-lg font-medium hover:underline">Contact</a>
            <a href="{{ route('about') }}" class="text-white text-lg font-medium hover:underline">About</a>
        </div>
    </nav>
    <section class="max-w-4xl mx-auto mb-16 bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold text-[#14543A] mb-2">About</h2>
        <p class="text-gray-700">This Library Management System allows you to search for books, explore categories, and check availability. Designed for ease of use and accessibility, it helps you find the resources you need quickly and efficiently.</p>
    </section>
</x-guest-layout>
