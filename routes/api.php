<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Middleware\EmployerRoleMiddleware;
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
});

// Employer routes
Route::middleware(['auth:sanctum', EmployerRoleMiddleware::class])->prefix('employer')->group(function () {
    Route::post('/create', [EmployerController::class, 'store'])->name('employer.store');
    Route::get('/{id}', [EmployerController::class, 'show'])->name('employer.show');
    Route::put('/{id}', [EmployerController::class, 'update'])->name('employer.update');
    Route::delete('/{id}', [EmployerController::class, 'destroy'])->name('employer.destroy');
    Route::post('/{employerId}/logo', [EmployerController::class, 'updateLogo'])->name('employer.updateLogo');

    // TO-DO (prefix: jobs)
    // POST   employer/jobs
    // GET    employer/jobs/list (paginated, search by title)
    // GET    employer/jobs/{job}
    // PUT    employer/jobs/{job}
    // DELETE employer/jobs/{job}

});
