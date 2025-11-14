<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika pengguna tidak login ATAU rolenya BUKAN 'user'
        if (!Auth::check() || Auth::user()->role !== 'user') {
            // Redirect ke halaman beranda
            return redirect(route('beranda.wisatawan'));
        }
        return $next($request);
    }
}