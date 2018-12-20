<?php

namespace FRohlfing\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificationController extends Controller
{
	/**
     * Send an email to verify the email address (ones more).
	 *
	 * @return \Illuminate\Http\RedirectResponse
     */
	public function send() //resend()
	{
        /** @var User $user */
        $user = Auth::user();
		if ($user->confirmed) {
			return redirect()->back()->with('message', __('auth.register.email_already_verified'));
		}

		send_verification_mail($user);

		return redirect()->back()->with('message', __('auth.register.email_sent'));
	}

	/**
	 * Confirm the email address.
	 *
     * @param \Illuminate\Http\Request $request
	 * @param string $confirmationToken
	 * @return \Illuminate\View\View
	 */
	public function confirm(Request $request, $confirmationToken)
	{
	    $email = $request->input('email');
		/** @var User $user */
		$user = User::whereConfirmationToken($confirmationToken)->whereEmail($email)->first();
		if ($user === null) {
			abort(Response::HTTP_FORBIDDEN, __('auth.register.token_invalid'));
		}

        $user->confirmation_token = null;
        $user->save();

		return view('auth::confirm', compact('user'));
	}
}
