<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ChekAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda Tidak Mempunyai Akses Ke Halaman Ini.');
        }
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk ini');
        }
        return $next($request);
    }
}
