# Package Skeleton for Laravel 5

This package provides following features:

- Only a skeleton for a package for Laravel 5

![Screenshot](https://raw.githubusercontent.com/frohlfing/app/master/resources/docs/package-skeleton.png)     

## Installation
    
I have not yet deployed this package to Packagist, the Composers default package archive. Therefore, you must tell 
Composer where the package is. To do this, add the following lines into your `composer.json`:

    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/frohlfing/laravel-package-skeleton.git"
        }
    ],

Download this package by running the following command:

    composer require frohlfing/laravel-package-skeleton:1.0.*@dev

You need to publish the config file for this package. This will add the file `config/package-skeleton.php`, where you 
can configure this package:

    php artisan vendor:publish --provider="FRohlfing\PackageSkeleton\PackageSkeletonServiceProvider" --tag=config

In order to edit the default templates, the views must be published as well. The views will then be placed in 
`resources/views/vendor/usermanagement`.

    php artisan vendor:publish --provider="FRohlfing\PackageSkeleton\PackageSkeletonServiceProvider" --tag=views

Publish the assets by running the following command:

    php artisan vendor:publish --provider="FRohlfing\PackageSkeleton\PackageSkeletonServiceProvider" --tag=public
    
You need to run the migrations for this package:

    php artisan vendor:publish --provider="FRohlfing\PackageSkeleton\PackageSkeletonServiceProvider" --tag=migrations
    php artisan migrate
    
Add menu item:    

todo
    
## Usage

The user manual...