<div class="bg-[#FAF9F6] h-20 flex items-center relative">
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
