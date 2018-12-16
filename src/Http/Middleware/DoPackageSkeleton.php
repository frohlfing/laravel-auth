<?php

namespace FRohlfing\PackageSkeleton\Http\Middleware;

use Closure;

class DoPackageSkeleton
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $pass = auth()->check();
        if (!$pass) {
            return response('Forbidden', 403);
        }

        return $next($request);
    }
}
