<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        // 1. Mitigasi Clickjacking (X-Frame-Options)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 2. Cegah MIME Sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 3. Kebijakan Referrer yang Aman
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 4. Isolasi Origin dengan COOP (Cross-Origin-Opener-Policy)
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');

        // 5. Pembatasan Izin Fitur Browser (Permissions Policy)
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self)');

        // 6. Kebijakan HSTS Kuat (HTTP Strict Transport Security) - Hanya aktif jika HTTPS
        if ($request->isSecure() || app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // 7. Content Security Policy (CSP) untuk Mitigasi XSS & Clickjacking
        $csp = [
            "default-src 'self' https: data:",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://unpkg.com https://cdn.jsdelivr.net https://app.sandbox.midtrans.com https://app.midtrans.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net https://fonts.bunny.net",
            "font-src 'self' data: https://fonts.gstatic.com https://cdn.jsdelivr.net https://fonts.bunny.net",
            "img-src 'self' data: https: blob:",
            "frame-src 'self' https://app.sandbox.midtrans.com https://app.midtrans.com",
            "frame-ancestors 'self'",
            "connect-src 'self' https:",
            "object-src 'none'",
            "base-uri 'self'",
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $csp));

        return $response;
    }
}
