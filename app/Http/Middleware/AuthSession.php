<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $token = Session::get('token');
        $expiresAt = Session::get('token_expires_at');

        // Kalau belum login (tidak ada token)
        if (!$token) {
            return redirect('/login')->withErrors(['session' => 'Silakan login terlebih dahulu.']);
        }

        // Kalau token sudah kedaluwarsa
        if ($expiresAt && now()->gt($expiresAt)) {
            Session::flush();
            return redirect('/login')->withErrors(['session' => 'Sesi Anda sudah berakhir. Silakan login lagi.']);
        }

        return $next($request);
    }
}
