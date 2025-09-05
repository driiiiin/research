<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // Generate a 6-character captcha code and SVG
        $captcha = $this->generateCaptchaCode();
        $svg = $this->generateCaptchaSvg($captcha);

        // Store captcha in session with unique identifier
        $captchaId = Str::random(32);
        session([
            'captcha_id' => $captchaId,
            'captcha_code_' . $captchaId => $captcha,
            'captcha_svg_' . $captchaId => $svg,
            'captcha_created_at_' . $captchaId => now()->timestamp
        ]);

        return view('auth.login', [
            'captcha_id' => $captchaId,
            'captcha_svg' => $svg
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Rate limiting for login attempts
        $throttleKey = 'login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withInput($request->except('password'))
                ->withErrors(['email' => "Too many login attempts. Please try again in {$seconds} seconds."]);
        }

        // Validate captcha
        $captchaId = $request->input('captcha_id');
        $captchaInput = $request->input('captcha_input');

        if (!$this->validateCaptcha($captchaId, $captchaInput)) {
            RateLimiter::hit($throttleKey);

            // Log failed captcha attempt
            Log::warning('Failed captcha attempt', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'captcha_id' => $captchaId,
                'provided_input' => $captchaInput
            ]);

            // Generate new captcha for next attempt
            $newCaptcha = $this->generateCaptchaCode();
            $newSvg = $this->generateCaptchaSvg($newCaptcha);
            $newCaptchaId = Str::random(32);

            session([
                'captcha_id' => $newCaptchaId,
                'captcha_code_' . $newCaptchaId => $newCaptcha,
                'captcha_svg_' . $newCaptchaId => $newSvg,
                'captcha_created_at_' . $newCaptchaId => now()->timestamp
            ]);

            return back()->withInput($request->except(['password', 'captcha_input']))
                ->withErrors(['captcha_input' => 'Incorrect captcha. Please try again.'])
                ->with('captcha_id', $newCaptchaId)
                ->with('captcha_svg', $newSvg);
        }

        // Clear captcha from session after successful validation
        $this->clearCaptcha($captchaId);

        $request->authenticate();
        $request->session()->regenerate();

        // Store session ID and set password change required flag
        $user = $request->user();
        $user->session_id = session()->getId();

        // Set password change required to true for first-time logins or if not set
        if (!isset($user->password_change_required)) {
            $user->password_change_required = true;
        }

        $user->save();

        // Clear rate limiting on successful login
        RateLimiter::clear($throttleKey);

        // Check if password change is required
        if ($user->isPasswordChangeRequired()) {
            return redirect()->route('password.change')
                ->with('warning', 'Please change your password to continue.');
        }

        return redirect()->intended(route('dashboard', absolute: false))
            ->with('success', 'You are now logged in.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Generate a random captcha code
     */
    private function generateCaptchaCode(): string
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
        $captcha = '';
        for ($i = 0; $i < 6; $i++) {
            $captcha .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $captcha;
    }

    /**
     * Validate captcha input
     */
    private function validateCaptcha(?string $captchaId, ?string $captchaInput): bool
    {
        if (!$captchaId || !$captchaInput) {
            return false;
        }

        $storedCode = session('captcha_code_' . $captchaId);
        $createdAt = session('captcha_created_at_' . $captchaId);

        // Check if captcha exists and is not expired (15 minutes)
        if (!$storedCode || !$createdAt || (now()->timestamp - $createdAt) > 900) {
            return false;
        }

        // Case-insensitive comparison with trimmed input
        $cleanInput = trim($captchaInput);
        if (empty($cleanInput)) {
            return false;
        }

        return strtolower($cleanInput) === strtolower($storedCode);
    }

    /**
     * Clear captcha from session
     */
    private function clearCaptcha(string $captchaId): void
    {
        session()->forget([
            'captcha_code_' . $captchaId,
            'captcha_svg_' . $captchaId,
            'captcha_created_at_' . $captchaId
        ]);
    }

    // Generate SVG with effects
    private function generateCaptchaSvg($text)
    {
        $svgWidth = 360;
        $svgHeight = 60;
        $svg = '<svg width="' . $svgWidth . '" height="' . $svgHeight . '" viewBox="0 0 ' . $svgWidth . ' ' . $svgHeight . '" xmlns="http://www.w3.org/2000/svg">';
        // Background gradient
        $svg .= '<defs><linearGradient id="bg" x1="0" y1="0" x2="1" y2="0"><stop offset="0%" stop-color="#e0e7ff"/><stop offset="100%" stop-color="#f0fdf4"/></linearGradient></defs>';
        $svg .= '<rect width="' . $svgWidth . '" height="' . $svgHeight . '" rx="16" fill="url(#bg)"/>';
        // Noise lines
        for ($i = 0; $i < 4; $i++) {
            $x1 = rand(0, $svgWidth); $y1 = rand(0, $svgHeight); $x2 = rand(0, $svgWidth); $y2 = rand(0, $svgHeight);
            $svg .= "<line x1='$x1' y1='$y1' x2='$x2' y2='$y2' stroke='#14532d' stroke-opacity='0.3' stroke-width='3'/>";
        }
        // Text with random color/rotation
        $charCount = strlen($text);
        $spacing = $svgWidth / ($charCount + 1);
        for ($i = 0; $i < $charCount; $i++) {
            $angle = rand(-18, 18);
            $color = sprintf('#%02X%02X%02X', rand(20,60), rand(83,120), rand(45,80));
            $x = $spacing * ($i + 1) + rand(-6,6);
            $y = $svgHeight / 2 + rand(8,16);
            $svg .= "<text x='$x' y='$y' font-size='38' font-family='Segoe UI, Arial, sans-serif' fill='$color' font-weight='bold' transform='rotate($angle $x $y)' style='text-shadow:1px 1px 2px #b6e3c6;'>" . htmlspecialchars($text[$i]) . "</text>";
        }
        // Dots
        for ($i = 0; $i < 30; $i++) {
            $cx = rand(0, $svgWidth); $cy = rand(0, $svgHeight); $r = rand(2, 5);
            $svg .= "<circle cx='$cx' cy='$cy' r='$r' fill='#14532d' fill-opacity='0.12'/>";
        }
        $svg .= '</svg>';
        return $svg;
    }

    /**
     * Refresh captcha via AJAX
     */
    public function refreshCaptcha()
    {
        // Generate a new 6-character captcha code and SVG
        $captcha = $this->generateCaptchaCode();
        $svg = $this->generateCaptchaSvg($captcha);

        // Store captcha in session with unique identifier
        $captchaId = Str::random(32);
        session([
            'captcha_id' => $captchaId,
            'captcha_code_' . $captchaId => $captcha,
            'captcha_svg_' . $captchaId => $svg,
            'captcha_created_at_' . $captchaId => now()->timestamp
        ]);

        return response()->json([
            'success' => true,
            'captcha_id' => $captchaId,
            'captcha_svg' => $svg
        ]);
    }
}
