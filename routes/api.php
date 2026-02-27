<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\CompanySocialController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\ResumesController;
use App\Http\Controllers\SaveJobController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Public Routes for unauthenticated user to see job posting offer
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{id}', [JobController::class, 'show']);
Route::middleware(['jwt.cookie'])->group(function () {

    // Shared authenticated reads
    Route::get('/applications', [ApplicationController::class, 'index']);
    Route::get('/applications/{id}', [ApplicationController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/jobcategories', [JobCategoryController::class, 'index']);
    Route::get('/jobcategories/{id}', [JobCategoryController::class, 'show']);
    Route::get('/jobtypes', [JobTypeController::class, 'index']);
    Route::get('/jobtypes/{id}', [JobTypeController::class, 'show']);

    // User routes
    Route::middleware('role:user')->group(function() {
        Route::controller(CandidateProfileController::class)->prefix('profiles')->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'create');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'delete');
        });

        Route::controller(ResumesController::class)->prefix('resumes')->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'create');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'delete');
        });

        Route::controller(SaveJobController::class)->prefix('save-jobs')->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'create');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'delete');
        });

        Route::post('/applications', [ApplicationController::class, 'create']);
    });

    // Employer routes
    Route::middleware("role:employer")->group(function() {
        Route::controller(CompaniesController::class)->prefix('companies')->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'create');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'delete');
        });
    
        Route::controller(CompanySocialController::class)->prefix('company-socials')->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'create');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'delete');
        });
    
        Route::controller(JobController::class)->prefix('jobs')->group(function () {
            Route::post('/', 'create');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'delete');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Application write access (matches controller logic)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:user,employer,admin')->group(function () {
        Route::put('/applications/{id}', [ApplicationController::class, 'update']);
        Route::delete('/applications/{id}', [ApplicationController::class, 'delete']);
    });

    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users',[UserController::class, 'index']);

        Route::controller(JobTypeController::class)->prefix('jobtypes')->group(function () {
            Route::post('/', 'create');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'delete');
        });

        Route::controller(JobCategoryController::class)->prefix('jobcategories')->group(function () {
            Route::post('/', 'create');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'delete');
        });

        Route::controller(CandidateProfileController::class)->prefix('profiles')->group(function () {
            Route::get('/admin/{id}', 'findProfile');
            Route::delete('/admin//{id}', 'adminDelete');
        });

        Route::controller(CompaniesController::class)->prefix('companies')->group(function () {
            Route::get('/admin/{id}', 'findCompany');
            Route::delete('/admin//{id}', 'adminDelete');
        });

        Route::controller(CompanySocialController::class)->prefix('company-socials')->group(function () {
            Route::get('/admin/{id}', 'findCompanySocial');
            Route::delete('/admin/{id}', 'adminDelete');
        });

        Route::controller(JobController::class)->prefix('jobs')->group(function () {
            Route::put('/admin/{id}', 'adminUpdate');
            Route::delete('/admin/{id}', 'adminDelete');
        });
    });
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);