<?php

namespace FRohlfing\Auth\Http\Middleware;

use Closure;
use Illuminate\Auth\SessionGuard;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $roles
     * @param string|null $guard
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, $roles, $guard = null)
    {
        /** @var SessionGuard $auth */
        $auth = Auth::guard($guard);
        $auth->authenticate();

        /** @var \App\User $user */
        $user = $auth->user();
        $user->getRules();

        $pass = in_array($user->role, explode('|', $roles));
        if (!$pass) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
