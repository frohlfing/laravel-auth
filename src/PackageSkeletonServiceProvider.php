<?php

namespace FRohlfing\PackageSkeleton;

use FRohlfing\PackageSkeleton\Console\Commands\RunPackageSkeletonCommand;
use FRohlfing\PackageSkeleton\Services\PackageSkeletonService;
use Illuminate\Support\ServiceProvider;

class PackageSkeletonServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * Wenn das Package Routen beinhaltet, muss hier false stehen!
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        // merge the custom config
        $this->mergeConfigFrom(__DIR__ . '/../config/package-skeleton.php', 'package-skeleton');

        // Register class

        $this->app->singleton(PackageSkeletonService::class, function ($app) {
            $config = $app['config']['package-skeleton'];
            return new PackageSkeletonService($config['foo_bar']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * This method is called after all other service providers have been registered, meaning you have access to all
     * other services that have been registered by the framework.
     *
     * @return void
     */
    public function boot()
    {
        // config
        $this->publishes([__DIR__ . '/../config/package-skeleton.php' => config_path('package-skeleton.php')], 'config');

        // routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], 'migrations');

        // translation (e.g.: echo trans('package-skeleton::messages.welcome'))
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'package-skeleton');
        $this->publishes([__DIR__ . '/../resources/lang/' => resource_path('lang/vendor/package-skeleton')], 'lang');

        // views (e.g. view('package-skeleton::index'))
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'package-skeleton');
        $this->publishes([__DIR__ . '/../resources/views' => resource_path('views/vendor/package-skeleton')], 'views');

        // assets
        $this->publishes([__DIR__ . '/../public' => public_path('vendor/frohlfing/package-skeleton/')], 'public');

        // commands
        if ($this->app->runningInConsole()) {
            $this->commands([RunPackageSkeletonCommand::class]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [PackageSkeletonService::class];
    }
}
