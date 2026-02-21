<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobApplicationController;
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
        Route::post('/', [JobSeekerController::class, 'store'])->name('job_seeker.store');
        Route::get('/{jobSeekerId}', [JobSeekerController::class, 'show'])->name('job_seeker.show');
        Route::put('/{jobSeekerId}', [JobSeekerController::class, 'update'])->name('job_seeker.update');
        Route::post('/{jobSeekerId}/resume', [JobSeekerController::class, 'updateResume'])->name('job_seeker.updateResume');
        // DELETE: '/{id}/delete (delete job seeker profile)
        Route::delete('/{jobSeekerId}', [JobSeekerController::class, 'destroy'])->name('job_seeker.destroy');
        // RESTORE: '/{id}/restore' (restore job seeker profile)
        Route::post('/{jobSeekerId}/restore', [JobSeekerController::class, 'restore'])->name('job_seeker.restore');
    });
#endregion

#region Job Application Routes
// (GENERAL)

// GET: '/' (view paginated application list)
Route::middleware('auth:sanctum')->get('/job-application', [JobApplicationController::class, 'index'])->name('job_application.index');
// GET: '/{applicationId} (view applicaton details)
Route::middleware('auth:sanctum')->get('/job-application/{jobApplicationId}', [JobApplicationController::class, 'show'])->name('job_application.show');
// PUT: '{applicationId}/status' (update application status)
// Employer - viewed, shortlisted, accepted, rejected
// Job Seeker - withdrawn
Route::middleware('auth:sanctum')->put('/job-application/{jobApplicationId}', [JobApplicationController::class, 'updateStatus'])->name('job_application.updateStatus');

// (JOB SEEKER)
Route::middleware(['auth:sanctum', 'role:job_seeker'])
    ->prefix('job-application')
    ->group(function () {
        // POST: '/' (create application)
        Route::post('/', [JobApplicationController::class, 'store'])->name('job_application.store');
        // PUT: '{applicationId}/' (update application details)
        Route::put('/{jobApplicationId}', [JobApplicationController::class, 'update'])->name('job_application.update');
        // DELETE: '/{applicationId}' (delete job application)'
        Route::delete('/{jobApplicationId}', [JobApplicationController::class, 'destroy'])->name('job_application.destroy');
        // POST: '/{applicationId}/restore' (restore deleted job application)
        Route::post('/{jobApplicationId}/restore', [JobApplicationController::class, 'restore'])->name('job_application.restore');
    });
#endregion
