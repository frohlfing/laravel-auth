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

    composer require frohlfing/laravel-auth:1.57.*@dev
    
Override the configuration file to `config/auth.php`:
        
    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=config --force
    
Override the `User` model:

    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=models --force   
       
Set the User Key Attribute in the configuration file, then run the database migration:
        
    php artisan migrate

You can delete the following files because they are no longer in use:            
            
- `app/Http/Controllers/Auth/`
- `resources/lang/en/auth.php`
- `resources/lang/en/password.php`
                  
## Customize
    
### Views

If you want to change the views of the package, they must be published. The views are then placed in 
`resources/views/vendor/auth`.

    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=views
    
Note: If you like to add additions user attributes, you may add the partials `_form.blade.php` and `_show.blade.php` to 
this folder which are included by the existing views. 

### Translation

If you want to change the translation, publish the language files to `resources/lang/vendor/auth`:

    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=lang
    
### Migrations

Further, you can publish the migrations:

    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=migrations
    
### Menu    

You may insert the personal menu items items to login and logout like this:

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        @include('auth::_nav')
    </ul>
    
## Middleware

This package provides the middleware `CheckRole`. Register them in `app/Http/Kerel.php`:    

    protected $routeMiddleware = [
        'role' => \FRohlfing\Auth\Http\Middleware\CheckRole::class,
    ];
    
After then you could use the middleware to check the role of the current user:
    
    Route::middleware(['role:master'])->group(function () {
        ...
    });
    
Or check the ability of the user as follows:
    
    Route::middleware(['auth', 'can:manage-users'])->group(function () {
        ...
    });

Write this to make sure the email address has been verified:

    Route::middleware(['auth', 'verified'])->group(function () {
        ...
    });

To protect the api requests using token authentication and rate limiting:

    Route::middleware(['auth:api', 'throttle:rate_limit,1'])->group(function () {
        ...
    });
