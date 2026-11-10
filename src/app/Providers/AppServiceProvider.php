<?php

namespace App\Providers;

use App\Services\Repository\RepositoryDatabase;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        config([
            'database.connections.repository.database' => config('repository.db_path'),
        ]);
        $this->app->singleton(RepositoryDatabase::class, function () {
            $repository = new RepositoryDatabase();
            $repository->initialize();

            return $repository;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    
    }
}
