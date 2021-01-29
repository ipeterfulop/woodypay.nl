<?php

namespace App\Providers;

use App\ViewComposers\AdminMenuViewComposer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('Translation', function() {
            return new App\Models\Translation();
        });
        app()->bind('translation', \App\Models\Translation::class);
        \View::composer('admin.*', AdminMenuViewComposer::class);
    }
}
