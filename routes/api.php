<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobSeekerController;
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
#endregion

#region Job Seeker Routes
Route::middleware(['auth:sanctum', 'role:job_seeker'])
    ->prefix('job_seeker')
    ->group(function () {

        // Job Seeker Routes
        // POST: '/' (create job seeker profile)
        Route::post('/', [JobSeekerController::class, 'store'])->name('job_seeker.store');
        // GET: /{id} (view job seeker profile)
        Route::post('/{jobSeekerId}', [JobSeekerController::class, 'show'])->name('job_seeker.show');
        // PUT: /{id} (update jobseeker profile)
        Route::put('/{jobSeekerId}', [JobSeekerController::class, 'update'])->name('job_seeker.update');
        // POST: /{id}/resume (update job seeker resume)
        Route::put('/{jobSeekerId}', [JobSeekerController::class, 'update'])->name('job_seeker.update');
        // DELETE: '/{id}/delete (delete job seeker profile)
        Route::delete('/{jobSeekerId}', [JobSeekerController::class, 'destroy'])->name('job_seeker.destroy');
        // RESTORE: '/{id}/restore' (restore job seeker profile)
        Route::delete('/{jobSeekerId}/restore', [JobSeekerController::class, 'restore'])->name('job_seeker.restore');
    });
#endregion

#region Job Application Routes (EMPLOYER SIDE)
    // 'employer/applications'
    // GET: '/' (view paginated application list)
    // PUT: '{applicationId}/status' (update application status)
#endregion

#region Job Application Routes (JOB SEEKER SIDE)
    // 'job_seeker/applications'
    // POST: '/' (create application)
    // GET: '/' (view paginated application list)
    // GET: '/{applicationId} (view applicaton details)
    // PUT: '{applicationId}/' (update application details)
    // PUT: '{applicationId}/status' (update application status)
#endregion
