<?php
namespace App\Application\Providers;
use Illuminate\Support\ServiceProvider;
use App\Infrastructure\StatisticBundle\Repository\StatisticRepository;
use App\Domain\StatisticInterface;
class RepositoryProvider extends ServiceProvider
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
        $this->app->bind(StatisticInterface::class, StatisticRepository::class);
    }
}
