<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware([
    'api',
    'auth:sanctum',
])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/me', [AuthController::class, 'me'])
        ->name('me');
    Route::post('/profile/avatar', [AuthController::class, 'updateAvatar'])->name('user.avatar');
});

#region Employer routes
Route::middleware(['auth:sanctum', 'role:employer'])
    ->prefix('employer')
    ->group(function () {

        Route::post('/create', [EmployerController::class, 'store'])->name('employer.store');
        Route::get('/{id}', [EmployerController::class, 'show'])->name('employer.show');
        Route::put('/{employerId}', [EmployerController::class, 'update'])->name('employer.update');
        Route::delete('/{employerId}', [EmployerController::class, 'destroy'])->name('employer.destroy');
        Route::post('/{employerId}/logo', [EmployerController::class, 'updateLogo'])->name('employer.updateLogo');
        Route::post('/{employerId}/restore', [EmployerController::class, 'restore'])->name('employer.restore');

        #region Employer job management routes
        Route::prefix('jobs')->group(function () {
            Route::post('/', [JobController::class, 'store'])->name('jobs.store');
            Route::get('/list', [JobController::class, 'index'])->name('jobs.index');
            Route::get('/{job}', [JobController::class, 'show'])->name('jobs.show');
            Route::put('/{job}', [JobController::class, 'update'])->name('jobs.update');
            Route::delete('/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
            Route::post('/{job}/restore', [JobController::class, 'restore'])->name('jobs.restore');
            Route::put('/{job}/status', [JobController::class, 'status'])->name('jobs.status');
        });
        #endregion
    });

Route::middleware(['auth:sanctum', 'role:job_seeker'])
    ->prefix('job_seeker')
    ->group(function () {

        
    });
#endregion
