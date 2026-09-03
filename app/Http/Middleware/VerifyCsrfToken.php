<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Mengecualikan rute callback Midtrans dari penjagaan CSRF
        '/midtrans-callback',
        'midtrans-callback',
        'midtrans-callback/*',
        '/midtrans-callback/*',
    ];
}
