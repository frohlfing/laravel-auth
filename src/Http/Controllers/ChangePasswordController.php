<?php

namespace FRohlfing\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Change Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password change requests.
    |
    */

    use RedirectsUsers;

    /**
     * Where to redirect users after change password.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new password change controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the password change view.
     *
     * @return \Illuminate\Http\Response
     */
    public function showChangeForm()
    {
        return view('auth::passwords.change');
    }

    /**
     * Handle a password change request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function change(Request $request)
    {
        /** @var \App\User $user */
        $user = Auth::user();

        $inputs = $request->input();
        $validator =  Validator::make($inputs, array_only($user->getRules(), 'password'));
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if (!Hash::check($inputs['old_password'], $user->password)) {
            return redirect()->back()->withInput()->withErrors(['old_password' => __('auth.password.password_invalid')]);
        }

        $user->password = bcrypt($inputs['password']);
        $user->save();

        return redirect($this->redirectPath());
    }
}