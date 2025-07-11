<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DepartmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('/', [UserController::class, 'store']);
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    Route::get('/user-statistics', [UserController::class, 'getUserStatistics']);

    Route::prefix('categories')->group(function () {
        Route::get('/major', [CategoryController::class, 'getMajorCategories']);
        Route::get('/{category}/minor', [CategoryController::class, 'getMinorCategories']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{category}', [CategoryController::class, 'show']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::delete('/{category}', [CategoryController::class, 'destroy']);
    });

    Route::get('/category-statistics', [CategoryController::class, 'getCategoryStatistics']);

    Route::prefix('assets')->group(function () {
        Route::post('/import', [AssetController::class, 'import']);
        Route::get('/export', [AssetController::class, 'export']);
        Route::get('/', [AssetController::class, 'index']);
        Route::post('/', [AssetController::class, 'store']);
        Route::get('/{asset}', [AssetController::class, 'show']);
        Route::put('/{asset}', [AssetController::class, 'update']);
        Route::delete('/{asset}', [AssetController::class, 'destroy']);
    });

    Route::prefix('organizations')->group(function () {
        Route::post('/', [OrganizationController::class, 'store']);
        Route::get('/', [OrganizationController::class, 'index']);
        Route::get('/{organization}', [OrganizationController::class, 'show']);
        Route::put('/{organization}', [OrganizationController::class, 'update']);
        Route::delete('/{organization}', [OrganizationController::class, 'destroy']);

        // Department routes
        Route::post('/{organization}/departments', [OrganizationController::class, 'addDepartment']);
        Route::delete('/{organization}/departments/{department}', [OrganizationController::class, 'deleteDepartment']);

        // Location routes
        Route::post('/{organization}/locations', [OrganizationController::class, 'addLocation']);
        Route::delete('/{organization}/locations/{location}', [OrganizationController::class, 'deleteLocation']);
    });

    Route::get('/asset-statistics', [AssetController::class, 'getAssetStatistics']);

    Route::get('/current-user', [UserController::class, 'getCurrentUser']);
});

// Public routes
Route::post('/login', [UserController::class, 'login']);

Route::get('/locations', [LocationController::class, 'index']);
Route::get('/departments', [DepartmentController::class, 'index']);

Route::get('/dashboard-stats', [AssetController::class, 'getDashboardStats']);
