<?php

namespace App\Providers;

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
        $this->app->bind(
            \App\Repositories\Client\ClientRepositoryInterface::class,
            \App\Repositories\Client\ClientRepository::class
        );

        $this->app->bind(
            \App\Repositories\Project\ProjectRepositoryInterface::class,
            \App\Repositories\Project\ProjectRepository::class
        );

        $this->app->bind(
            \App\Repositories\Todo\TodoRepositoryInterface::class,
            \App\Repositories\Todo\TodoRepository::class
        );

        $this->app->bind(
            \App\Repositories\Memo\MemoRepositoryInterface::class,
            \App\Repositories\Memo\MemoRepository::class
        );

        $this->app->bind(
            \App\Repositories\Sale\SaleRepositoryInterface::class,
            \App\Repositories\Sale\SaleRepository::class
        );

        $this->app->bind(
            \App\Repositories\Project\Record\RecordRepositoryInterface::class,
            \App\Repositories\Project\Record\RecordRepository::class
        );

        $this->app->bind(
            \App\Repositories\Subcontractor\SubcontractorRepositoryInterface::class,
            \App\Repositories\Subcontractor\SubcontractorRepository::class
        );
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
