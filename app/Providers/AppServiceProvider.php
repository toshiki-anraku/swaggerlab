<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Todo\TodoRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Todo\TodoRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
