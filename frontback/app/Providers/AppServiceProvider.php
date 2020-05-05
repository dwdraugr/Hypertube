<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        Schema::defaultStringLength(191);
        $this->bootEcoleSocialite();
    }

    private function bootEcoleSocialite()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
          'ecole',
          function ($app) use ($socialite) {
              $config = $app['config']['services.ecole'];
              return $socialite->buildProvider(EcoleAuthProvider::class, $config);
          }
        );
    }
}
