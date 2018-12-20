<?php

namespace FRohlfing\Auth\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckConfirmed
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @param string|null $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		$auth = Auth::guard($guard);

		/** @var User $user */
		$user = $auth->check() ? $auth->user() : null;

		if ($user === null || !$user->confirmed) {
			if ($request->ajax()) {
				return response('Unauthorized.', Response::HTTP_UNAUTHORIZED);
			}
			else {
				return redirect()->guest('profile');
			}
		}

		return $next($request);
	}

}