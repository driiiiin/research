<div class="w-full bg-[#e6f6f6] py-8" style="padding-bottom:0">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 items-start px-4">
        <!-- Column 1: Logo -->
        <div class="flex flex-col items-center md:items-start">
            <img src="{{ asset('images/phil-seal.png') }}" class="h-75 w-auto mb-2 opacity-100" alt="PH Seal">
        </div>
        <!-- Column 2: Republic of the Philippines -->
        <div class="flex flex-col items-center md:items-start">
            <span class="font-bold text-gray-700 text-lg">REPUBLIC OF THE PHILIPPINES</span>
            <span class="text-gray-700 text-sm">All content in the public domain unless otherwise stated.</span>
        </div>
        <!-- Column 3: About GOVPH -->
        <div>
            <span class="font-bold text-gray-700 text-lg">ABOUT GOVPH</span>
            <p class="text-gray-700 text-sm mt-1 mb-2">Learn more about the Philippine government, its structure, how government works and the people behind it.</p>
            <ul class="text-gray-700 text-sm space-y-1">
                <li><a href="https://www.gov.ph/" target="_blank" class="hover:underline">GOV.PH</a></li>
                <li><a href="https://data.gov.ph/" target="_blank" class="hover:underline">Open Data Portal</a></li>
                <li><a href="https://www.officialgazette.gov.ph/" target="_blank" class="hover:underline">Official Gazette</a></li>
            </ul>
        </div>
        <!-- Column 4: Government Links -->
        <div>
            <span class="font-bold text-gray-700 text-lg">GOVERNMENT LINKS</span>
            <ul class="text-gray-700 text-sm space-y-1 mt-1">
                <li><a href="https://op.gov.ph/" target="_blank" class="hover:underline">Office of the President</a></li>
                <li><a href="https://ovp.gov.ph/" target="_blank" class="hover:underline">Office of the Vice President</a></li>
                <li><a href="https://senate.gov.ph/" target="_blank" class="hover:underline">Senate of the Philippines</a></li>
                <li><a href="https://congress.gov.ph/" target="_blank" class="hover:underline">House of Representatives</a></li>
                <li><a href="https://sc.judiciary.gov.ph/" target="_blank" class="hover:underline">Supreme Court</a></li>
                <li><a href="https://ca.judiciary.gov.ph/" target="_blank" class="hover:underline">Court of Appeals</a></li>
                <li><a href="https://sb.judiciary.gov.ph/" target="_blank" class="hover:underline">Sandiganbayan</a></li>
            </ul>
        </div>
    </div>
    <div class="flex items-center relative">
    <div class="w-full flex flex-row items-center justify-between px-4 py-2">
        <div class="flex items-center">
            <span class="text-xs">&copy;{{ date('Y') }} Department of Health. All rights reserved.</span>
            <img src="{{ asset('images/S-DOH-logo.png') }}" class="h-6 w-auto ml-2" alt="DOH Logo">
        </div>
        <div class="flex items-center">
            <span class="text-xs">
                Page load time: <span id="loadtime">0.000</span> seconds
            </span>
            <script>
                var startTime = performance.timing ? performance.timing.navigationStart : Date.now();
                document.addEventListener("DOMContentLoaded", function() {
                    var now = performance.now ? performance.now() : (Date.now() - startTime);
                    var seconds = (now / 1000).toFixed(3);
                    document.getElementById("loadtime").innerText = seconds;
                });
            </script>
        </div>
    </div>
    <!-- Back to Top Button -->
    <button id="backToTopBtn" title="Back to Top"
        style="display: none; position: fixed; bottom: 80px; right: 32px; z-index: 9999; background: #14532d; color: #fff; border: none; border-radius: 50%; width: 44px; height: 44px; box-shadow: 0 2px 8px rgba(20,83,45,0.18); cursor: pointer; transition: opacity 0.3s;">
        <i class="bi bi-arrow-up" style="font-size: 1.3rem;"></i>
    </button>
    <script>
        // Show/hide back to top button on scroll
        window.addEventListener('scroll', function() {
            var btn = document.getElementById('backToTopBtn');
            if (window.scrollY > 50) {
                btn.style.display = 'block';
            } else {
                btn.style.display = 'none';
            }
        });

        // Scroll to top when button is clicked
        document.getElementById('backToTopBtn').addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</div>

</div>
