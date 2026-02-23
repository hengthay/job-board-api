<?php

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['jwt.cookie'])->group(function () {

    Route::get('/users', [UserController::class, 'index']);

    Route::controller(JobCategoryController::class)->prefix('jobcategories')->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });
    Route::controller(JobTypeController::class)->prefix('jobtypes')->group(function () {
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
    Route::controller(CandidateProfileController::class)->prefix('profiles')->group(function () {
        Route::get('/', 'index');
        Route::get('/admin/{id}', 'findProfile');
        Route::get('/{id}', 'show');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::delete('/admin/{id}', 'adminDelete');
    });
    Route::controller(CompaniesController::class)->prefix('companys')->group(function () {
        Route::get('/', 'index');
        Route::get('/admin/{id}', 'findCompany');
        Route::get('/{id}', 'show');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::delete('/admin/{id}', 'adminDelete');
    });
    Route::controller(CompanySocialController::class)->prefix('company-socials')->group(function () {
        Route::get('/', 'index');
        Route::get('/admin/{id}', 'findCompanySocial');
        Route::get('/{id}', 'show');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
        Route::delete('/admin/{id}', 'adminDelete');
    });
    Route::controller(JobController::class)->prefix('jobs')->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'create');
        Route::put('/{id}', 'update')->middleware('role:employer');
        Route::put('/admin/{id}', 'adminUpdate')->middleware('role:admin');
        Route::delete('/{id}', 'delete')->middleware('role:employer');;
        Route::delete('/admin/{id}', 'adminDelete')->middleware('role:admin');;
    });
    Route::controller(SaveJobController::class)->prefix('save-jobs')->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });
});

// Route::get('/users', [UserController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);