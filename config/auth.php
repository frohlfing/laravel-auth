<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver'   => 'token',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table'  => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_resets',
            'expire'   => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Minimum Length of User Password
    |--------------------------------------------------------------------------
    |
    | Here you may specify the minimum length of the user password.
    |
    */

    'password_length' => 6,

    /*
    |--------------------------------------------------------------------------
    | Authentication Key
    |--------------------------------------------------------------------------
    |
    | Determine which user attribute is used by the login (default: email).
    |
    */

    'key' => 'email',
    //'key' => 'username',

    /*
    |--------------------------------------------------------------------------
    | Registration Feature
    |--------------------------------------------------------------------------
    |
    | Set this option if users are allowed to register to get an account.
    |
    */

    'registration' => true,

    /*
    |--------------------------------------------------------------------------
    | Forgot Password Feature
    |--------------------------------------------------------------------------
    |
    | Set this option to provide the forgot password feature.
    |
    */

    'forgot_password' => true,

    /*
    |--------------------------------------------------------------------------
    | Login Throttling
    |--------------------------------------------------------------------------
    |
    | By default, the user will not be able to login for one minute if they fail
    | to provide the correct credentials after several attempts. The throttling
    | is unique to the user's username / e-mail address and their IP address.
    |
    */

    'login_throttling' => [
        'max_attempts'  => 5,
        'decay_minutes' => 1,
    ],

    /*
    |--------------------------------------------------------------------------
    | Number of Users per Page
    |--------------------------------------------------------------------------
    |
    | This option defines the maximum number of users per management page.
    |
    */

    'per_page' => 20,

    /*
    |--------------------------------------------------------------------------
    | API-Token
    |--------------------------------------------------------------------------
    |
    | Set this option to manage the api token and api_rate_limit.
    |
    */

    'manage_api' => true,

    /*
    |--------------------------------------------------------------------------
    | Maximum Number of API Requests
    |--------------------------------------------------------------------------
    |
    | You can set the maximum number of API requests a new user can make per
    | minute.
    |
    */

    'api_rate_limit' => 60,

    /*
    |--------------------------------------------------------------------------
    | User Roles
    |--------------------------------------------------------------------------
    |
    | Here you may specify the available user roles.
    | The first entry is the default role for a new created user.
    | Max. name length: 16 (see table users)
    |
    */

    'roles' => [
        'user',
        'admin',
        'master',
    ],

    /*
    |--------------------------------------------------------------------------
    | Access Control List
    |--------------------------------------------------------------------------
    |
    | To control the access you may define the user abilities.
    | The AuthServiceProvider uses this list to register the abilities.
    |
    */

    'acl' => [
        'manage'        => ['master', 'admin'],
        'manage-users'  => ['master', 'admin'],
        'manage-system' => ['master'],
    ],

];
