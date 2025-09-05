<x-guest-layout>
    <nav class="w-full bg-[#14543A] shadow rounded-2xl mb-4">
        <div class="flex items-center h-16 px-6 space-x-8">
            <a href="{{ route('welcome') }}" class="text-white text-lg font-medium hover:underline">Home</a>
            <a href="{{ route('contact') }}" class="text-white text-lg font-medium hover:underline">Contact</a>
            <a href="{{ route('about') }}" class="text-white text-lg font-medium hover:underline">About</a>
        </div>
    </nav>
    <section class="max-w-7xl mx-auto mt-8 mb-8 bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold text-[#14543A] mb-2">Contact</h2>
        <div class="text-gray-700 mb-2">
            Health Policy Development and Planning Bureau - Health Research Division
        </div>
        <div class="mb-2">
            <a href="mailto:healthresearch@doh.gov.ph" class="text-indigo-600 hover:underline">healthresearch@doh.gov.ph</a>
        </div>
        <div class="text-gray-700">
            8651-7800 local 1326/1328
        </div>
    </section>
</x-guest-layout>
