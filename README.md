# User Authentication for Laravel 5.7

This package provides following features: 
 - Register via double opt-in process
 - Reset password with email verification
 - Change password
 - User account administration
 - User roles
 - Access control list
 - API-token
 - Rate limit
 - User profile
 - Login either by e-mail or username (configurable)
 - Logout
  
## Installation
    
I have not yet deployed this package to Packagist, the Composers default package archive. Therefore, you must tell 
Composer where the package is. To do this, add the following lines into your `composer.json`:

    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/frohlfing/laravel-auth.git"
        }
    ],

Download this package by running the following command:

    composer require frohlfing/laravel-auth:1.0.*@dev
    
Publish the assets:

    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=public    
        
## Customize

### Configuration

This will add the file `config/auth.php`, where you can configure this package:

    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=config
    
### Views

If you want to change the views of the package, they must also be published. The views are then placed in 
`resources/views/vendor/auth`.

    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=views
    
Note: If you like to add additions user attributes, you may add the partials `_form.blade.php` and `_show.blade.php` to 
this folder which are included by the existing views. 

### Migrations

Further, you can publish the migrations for this package to modify them:

    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=migrations
    php artisan migrate
    
### Menu    

You may insert the personal menu items items to login and logout like this:

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        @include('auth::_nav')
    </ul>
    
## Middleware

This package provides a middleware `CheckRole`. Register them in `app/Http/Kerel.php`:    

    protected $routeMiddleware = [
        'role' => \FRohlfing\Auth\Http\Middleware\CheckRole::class,
    ];
    
After then you could use the middleware to check the role of the current user:
    
    Route::middleware(['role:master'])->group(function () {
        ...
    });
    
Or check the ability of the user as follows:
    
    Route::middleware(['can:manage-users'])->group(function () {
        ...
    });

Write this to make sure the email address has been verified:

    Route::middleware(['verified'])->group(function () {
        ...
    });

To protect the api requests using token authentication and rate limiting:

    Route::middleware(['auth:api', 'throttle:rate_limit,1'])->group(function () {
        ...
    });
