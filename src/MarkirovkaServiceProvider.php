<?php

namespace Massterski\DmMarkirovka;

use Illuminate\Support\ServiceProvider;

class MarkirovkaServiceProvider extends ServiceProvider
{
    /**
     * Регистрация любых служб приложения.
     *
     * @return void
     */
    public function register()
    {
      $this->app->singleton(ApiClient::class, function ($app) {
        return new ApiClient(config('services.ismet.base_uri'));
      });
    }

    /**
     * Выполнение любых начальных действий после загрузки всех служб.
     *
     * @return void
     */
    public function boot()
    {
      $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}

