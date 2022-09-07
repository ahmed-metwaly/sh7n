<?php

namespace App\Providers;

use App\Http\ViewComposers\PopularityComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer(
            'admin.layouts.analytics', PopularityComposer::class
        );
    }
}
