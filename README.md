# Extension of the User authentication for Laravel 5

This package provides following features: 
 - Registration with email verification
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

![Screenshot](https://raw.githubusercontent.com/frohlfing/app/master/resources/docs/screenshot-auth.png)     

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

You need to publish the config file for this package. This will add the file `config/auth.php`, where you can configure 
this package:

    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=config

In order to edit the default templates, the views must be published as well. The views will then be placed in 
`resources/views/vendor/auth`.

    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=views

Publish the assets by running the following command:

    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=public
    
You need to run the migrations for this package:

    php artisan vendor:publish --provider="FRohlfing\Auth\AuthServiceProvider" --tag=migrations
    php artisan migrate
    
Add menu item:    

todo
    
## Usage

todo

s. https://github.com/pletfix/auth-plugin

Configuration

Views

Web:
Roles, ACL, can

API:
api_token
rate_limit

