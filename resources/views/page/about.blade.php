<x-guest-layout>
    <nav class="w-full bg-[#14543A] shadow rounded-2xl mb-4">
        <div class="flex items-center h-16 px-6 space-x-8">
            <a href="{{ route('welcome') }}" class="text-white text-lg font-medium hover:underline">Home</a>
            <a href="{{ route('contact') }}" class="text-white text-lg font-medium hover:underline">Contact</a>
            <a href="{{ route('about') }}" class="text-white text-lg font-medium hover:underline">About</a>
        </div>
    </nav>
    <section class="max-w-7xl mx-auto mt-8 mb-8 bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold text-[#14543A] mb-2">About</h2>
        <div class="text-gray-700 space-y-4">
            <p>
                <strong>The Health Research Repository</strong>, an initiative spearheaded by the Department of Health's Health Policy Development and Planning Bureau (HPDPB) in collaboration with the Knowledge Management and Information Technology Service (KMITS), shall serve as a centralized platform for collecting and managing crucial evidence from the Department's research initiatives. Its primary aim is to streamline the process of gathering, preserving, sharing, and applying essential health research findings within the Department.
            </p>
            <p>
                By leveraging advanced technologies and robust data management systems, this initiative seeks to enhance the efficiency and accessibility of vital health insights. The repository encourages collaboration and knowledge exchange among health professionals, empowering the Department to develop evidence-informed policies.
            </p>
            <p>
                This strategic move reinforces the commitment to advancing healthcare through research, fostering a culture of continuous learning, and driving improvements in healthcare practices.
            </p>
            <p>
                Our repository is managed by dedicated teams from the Health Policy Development and Planning Bureau's Health Research Division and KMITS's Central Research. Allow us to introduce the esteemed members:
            </p>
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-[#14543A] mb-2">Health Policy Development and Planning Bureau - Health Research Division</h3>
                <ol class="list-decimal list-inside space-y-1 text-gray-800">
                    <li>Dr. Lilibeth C. David, MPH, MPM, CESO I</li>
                    <li>Dr. Lester M. Tan, MPH, MSC</li>
                    <li>Mr. Pio Justin V. Asuncion, RN, MPH, MOHRE, FRSPH</li>
                    <li>Ms. Renee Lyn Cabanero-Gasgonia, RN, MPH</li>
                    <li>Ms. Hanzel A. Barrameda</li>
                    <li>Ms. Myka Angela A. Cadag, RND</li>
                </ol>
            </div>
            <div class="mt-6">
                <h3 class="text-xl font-semibold text-[#14543A] mb-2">KMITS - Central Research</h3>
                <ol class="list-decimal list-inside space-y-1 text-gray-800">
                    <li>Ms. Maricel Paya</li>
                    <li>Ms. Samantha Ferol</li>
                    <li>Mr. Vince Dominic Curato</li>
                </ol>
            </div>
        </div>
    </section>
</x-guest-layout>
