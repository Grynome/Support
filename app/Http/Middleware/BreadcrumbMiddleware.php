<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BreadcrumbMiddleware
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
        $breadcrumbs = [];

        $segments = $request->segments();

        $url = '';
        foreach ($segments as $segment) {
            $url .= '/' . $segment;

            // Add breadcrumb for current page
            $breadcrumbs[] = [
                'url' => $url,
                'title' => ucfirst($segment)
            ];
        }

        // Add breadcrumb for home page
        $breadcrumbs = array_merge([
            [
                'url' => url('/'),
                'title' => 'Home'
            ]
        ], $breadcrumbs);

        session(['breadcrumbs' => $breadcrumbs]);

        return $next($request);
    }
}
