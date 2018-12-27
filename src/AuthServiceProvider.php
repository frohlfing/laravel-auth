<?php

namespace FRohlfing\Auth;

use FRohlfing\Auth\Console\Commands\AddUserCommand;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
        $this->mergeConfigFrom(__DIR__ . '/../config/auth.php', 'auth');
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
        $this->publishes([__DIR__ . '/../config/auth.php' => config_path('auth.php')], 'config');

        // routes
        Route::middleware(['web'])->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });

        // migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], 'migrations');

        // translation (e.g.: echo trans('auth::messages.welcome'))
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'auth');
        $this->publishes([__DIR__ . '/../resources/lang/' => resource_path('lang/vendor/auth')], 'lang');

        // views (e.g. view('auth::index'))
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'auth');
        $this->publishes([__DIR__ . '/../resources/views' => resource_path('views/vendor/auth')], 'views');

        // assets
        //$this->publishes([__DIR__ . '/../public' => public_path('vendor/auth')], 'public');

        // model
        $this->publishes([__DIR__ . '/../resources/stubs/User.php.stub' => app_path('User.php')], 'models');

        // commands
        if ($this->app->runningInConsole()) {
            $this->commands([AddUserCommand::class]);
        }

        // load ACL
        $this->registerAbilities();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Register the user abilities.
     *
     * @return void
     */
    protected function registerAbilities()
    {
        $acl = config('auth.acl');
        foreach ($acl as $ability => $roles) {
            Gate::define($ability, function ($user) use ($roles) {
                return in_array($user->role, $roles);
            });
        }
    }
}
