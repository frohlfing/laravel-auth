<?php

namespace FRohlfing\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $maxAttempts  = config('auth.verification_throttling.max_attempts', 6);
        $decayMinutes = config('auth.verification_throttling.decay_minutes', 1);
        $this->middleware("throttle:{$maxAttempts},{$decayMinutes}")->only('verify', 'resend');
        $this->redirectTo = config('auth.redirect_to_after_verify', '');
    }

    /**
     * Show the email verification notice.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail() ? redirect($this->redirectPath()) : view('auth::verify');
    }
}
