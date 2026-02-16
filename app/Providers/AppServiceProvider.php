<?php

namespace App\Providers;

use App\Repositories\Auth\UserRepositoryInterface;
use App\Repositories\Auth\UserRepository;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Employer\EmployerRepository;
use App\Repositories\Employer\EmployerRepositoryInterface;
use App\Repositories\File\FileRepository;
use App\Repositories\File\FileRepositoryInterface;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Employer\EmployerService;
use App\Services\Employer\EmployerServiceInterface;
use BaseRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class,  BaseRepository::class);
        $this->app->bind(AuthServiceInterface::class,  AuthService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
        $this->app->bind(EmployerServiceInterface::class, EmployerService::class);
        $this->app->bind(EmployerRepositoryInterface::class, EmployerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
