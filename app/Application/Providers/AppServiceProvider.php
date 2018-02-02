<?php

namespace App\Application\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\StatisticServiceInterface;
use App\Domain\Service\StatisticService;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(StatisticServiceInterface::class, StatisticService::class);
    }
}
