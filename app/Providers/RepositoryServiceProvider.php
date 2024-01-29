<?php

namespace App\Providers;

use App\Repositories\Eloquent\SaleRepository;
use App\Repositories\Interfaces\SaleRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
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
