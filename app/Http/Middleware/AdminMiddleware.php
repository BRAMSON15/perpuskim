<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('staf')->check()) {
            if (Auth::guard('staf')->user()->role === 'admin') {
                return $next($request);
            }
            return redirect('/stafperpus/home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return redirect('/admin/login')->with('error', 'Silakan login terlebih dahulu.');
    }
}
