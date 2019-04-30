<?php

namespace FRohlfing\Auth\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Show the current user.
     *
     * @return $this|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        return view('auth::profile.index', compact('user'));
    }

    /**
     * Show the edit view and gathers the old data.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();

        return view('auth::profile.form', compact('user'));
    }

    /**
     * Store an user to the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $keys = ['email', 'password', 'role'];
        if (config('auth.key') !== 'email') {
            $keys[] = config('auth.key');
        }
        $inputs = $request->except($keys);
        $validator = Validator::make($inputs, array_except($user->getRules(), $keys), [], __('auth::model'));
        if ($validator->fails()) {
            return Redirect::route('profile.edit')->withInput()->withErrors($validator);
        }

        $user->update($inputs);

        return Redirect::route('profile.index')->with('message', __('auth::profile.successful_updated'));
    }

    /**
     * Renew the API token.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function renewApiToken()
    {
        /** @var User $user */
        $user = Auth::user();

        $user->api_token = str_unique_random(60);
        $user->save();

        return Redirect::route('profile.index')->with('message', __('auth::profile.renewed_api_token'));
    }
}