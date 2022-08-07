<?php

namespace App\Providers;

use App\Contracts\SendSubscriberNotificationContract;
use App\Services\SendSubscriberNotificationService;
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
        $this->app->singleton(SendSubscriberNotificationContract::class, function ($app) {
            return new SendSubscriberNotificationService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
