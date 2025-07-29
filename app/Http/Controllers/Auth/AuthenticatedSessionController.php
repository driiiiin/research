<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // Generate a 6-character captcha code and SVG
        $captcha = '';
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
        for ($i = 0; $i < 6; $i++) {
            $captcha .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $svg = $this->generateCaptchaSvg($captcha);
        session(['captcha_code' => $captcha, 'captcha_svg' => $svg]);
        return view('auth.login', ['captcha_code' => $captcha, 'captcha_svg' => $svg]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Validate captcha
        if (strtolower($request->input('captcha_input')) !== strtolower(session('captcha_code'))) {
            // Regenerate captcha for next attempt
            $captcha = '';
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
            for ($i = 0; $i < 6; $i++) {
                $captcha .= $chars[random_int(0, strlen($chars) - 1)];
            }
            $svg = $this->generateCaptchaSvg($captcha);
            session(['captcha_code' => $captcha, 'captcha_svg' => $svg]);
            return back()->withInput($request->except('password'))
                ->withErrors(['captcha_input' => 'Incorrect captcha. Please try again.']);
        }
        // Regenerate captcha for next attempt
        $captcha = '';
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
        for ($i = 0; $i < 6; $i++) {
            $captcha .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $svg = $this->generateCaptchaSvg($captcha);
        session(['captcha_code' => $captcha, 'captcha_svg' => $svg]);

        $request->authenticate();

        $request->session()->regenerate();

        // Store session ID
        $user = $request->user();
        $user->session_id = session()->getId();
        $user->save();

        return redirect()->intended(route('dashboard', absolute: false));
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

    // AJAX captcha refresh
    public function refreshCaptcha(Request $request)
    {
        $captcha = '';
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
        for ($i = 0; $i < 6; $i++) {
            $captcha .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $svg = $this->generateCaptchaSvg($captcha);
        session(['captcha_code' => $captcha, 'captcha_svg' => $svg]);
        return response()->json(['captcha_svg' => $svg]);
    }
}
