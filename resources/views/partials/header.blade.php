<div class="bg-white border-b border-gray-100 fixed top-0 left-0 w-full z-50">
    <div class="mx-auto px-4 sm:px-6 lg:px-8 flex items-start">
        <!-- Logo and Title Group -->
        <div class="flex items-center" style="margin-left: 0.5rem;">
            <img src="{{ asset('images/DOH-logo.png') }}" alt="DOH Logo" style="height: 58px;" onerror="this.style.display='none'">
            <img src="{{ asset('images/BP-logo.png') }}" alt="BP Logo" style="height: 78px; vertical-align: middle;" onerror="this.style.display='none'">
            <div class="flex flex-col justify-center" style="height: 60px;">
                <span class="text-xs text-muted" style="font-size: 1.15rem; color: #14532d; line-height: 1; margin-bottom: 0.2rem; margin-left: 0.2rem; text-shadow: 2px 2px 8px rgba(20,83,45,0.25), 0 2px 6px rgba(0,0,0,0.18); text-decoration: underline;">
                    Department of Health
                </span>
                <span class="font-black uppercase tracking-widest" style="letter-spacing: 1px; color: #14532d; font-size: 2.5rem; line-height: 1; text-shadow: 3px 3px 10px rgba(20,83,45,0.35), 0 4px 12px rgba(0,0,0,0.25);">
                    {{ str_replace('_', ' ', config('app.name', 'Health Research Repository')) }}
                </span>
            </div>
        </div>
    </div>
</div>
