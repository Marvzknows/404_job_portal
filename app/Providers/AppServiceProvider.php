<?php

namespace App\Providers;

use App\Repositories\Auth\UserRepositoryInterface;
use App\Repositories\Auth\UserRepository;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\BaseRepositoryInterface;
use App\Repositories\Employer\EmployerRepository;
use App\Repositories\Employer\EmployerRepositoryInterface;
use App\Repositories\File\FileRepository;
use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\JobSeeker\JobSeekerRepository;
use App\Repositories\JobSeeker\JobSeekerRepositoryInterface;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Employer\EmployerService;
use App\Services\Employer\EmployerServiceInterface;
use App\Services\JobSeeker\JobSeekerService;
use App\Services\JobSeeker\JobSeekerServiceInterface;
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
        $this->app->bind(\App\Services\JobListing\JobListingServiceInterface::class, \App\Services\JobListing\JobListingService::class);
        $this->app->bind(\App\Repositories\JobListing\JobListingRepositoryInterface::class, \App\Repositories\JobListing\JobListingRepository::class);

        $this->app->bind(JobSeekerServiceInterface::class, JobSeekerService::class);
        $this->app->bind(JobSeekerRepositoryInterface::class, JobSeekerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
