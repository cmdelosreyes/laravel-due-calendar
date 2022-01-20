<?php

namespace App\Providers;

use App\Models\Event;
use App\Services\EventService;
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
        // Inject Event Model on Event Service
        $this->app->singleton(EventService::class, fn () => new EventService(new Event()));
    }
}
