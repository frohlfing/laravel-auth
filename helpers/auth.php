<?php

use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

if (!function_exists('user_name')) {
    /**
     * Get the display name of the current user.
     *
     * @return string
     */
    function user_name()
    {
        /** @var \App\User $user */
        $user = auth()->user();

        return $user->name;
    }
}

if (!function_exists('api_token')) {
    /**
     * Get the API token.
     *
     * @return string|null;
     */
    function api_token()
    {
        if (auth()->guest()) {
            return null;
        }

        /** @var \App\User $user */
        $user = auth()->user();

        return $user->api_token;
    }
}

if (!function_exists('is_superior')) {
    /**
     * Determine if the given user role is superior.
     *
     * @param User|string $userOrRole
     * @return bool
     */
    function is_superior($userOrRole)
    {
        $roles = array_flip(config('auth.roles'));

        $role = $userOrRole instanceof User ? $userOrRole->role : $userOrRole;

        /** @noinspection PhpUndefinedFieldInspection */
        return $role !== null && $roles[$role] > $roles[auth()->user()->role];
    }
}

if (!function_exists('send_verification_mail')) {
    // todo zum User-Model  packen (wird vom VerificationController und RegisterController verwendet)
    // oder User::sendPasswordResetNotification zum PasswortController packen

    /**
     * Send an email to the user for verification the email address.
     *
     * @param User $user
     */
    function send_verification_mail(User $user)
    {
        Mail::send('auth.emails.verify', compact('user'), function($message) use($user) {
            /** @var \Illuminate\Mail\Message $message */
            $message->to($user->email, $user->name)->subject(__('auth::emails.register.subject'));
        });

        /** @noinspection PhpUndefinedMethodInspection */
        Session::flash('message', __('auth::register.email_sent'));
    }
}
