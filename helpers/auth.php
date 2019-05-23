<?php

use App\User;

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
