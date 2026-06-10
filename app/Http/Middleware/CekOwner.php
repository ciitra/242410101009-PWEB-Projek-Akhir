<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role === 'owner') {
            return $next($request);
        }

        if (Auth::user()->role === 'customer') {
            return redirect()->route('customer.dashboard');
        }

        abort(403, 'Akses Ditolak! Halaman ini hanya untuk owner.');
    }
}
