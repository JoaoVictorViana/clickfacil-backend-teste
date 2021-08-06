<?php

namespace App\Providers;

use App\Http\Repositories\CakeRepository;
use App\Http\Repositories\EmailCakeRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CakeRepository::class, function() {
            return new CakeRepository();
        });

        $this->app->bind(EmailCakeRepository::class, function() {
            return new EmailCakeRepository();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
