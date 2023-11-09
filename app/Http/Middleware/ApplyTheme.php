<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApplyTheme
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('sidebarThemeSettings')) {
            $theme = session()->get('sidebarThemeSettings');
        } else {
            $theme = 'default';
        }

        // Tampilkan atau aplikasikan tema yang dipilih pengguna di sini
        return $next($request);
    }
}
