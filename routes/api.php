<?php

use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\Monitoring\CategoryController;
use App\Http\Controllers\Api\Monitoring\ImageController;
use App\Http\Controllers\Api\Monitoring\InputController;
use App\Http\Controllers\Api\Monitoring\MonitoringController;
use App\Http\Controllers\Api\Monitoring\ObjectDataController;
use App\Http\Controllers\Api\Monitoring\OptionController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->group(function() {
    Route::post('login', [UserController::class, 'login']);
    Route::post('verification', [UserController::class, 'verification']);
    Route::resource('/employee', EmployeeController::class);

    Route::middleware('auth:sanctum')->group(function() {
        Route::resource('/category-monitoring', CategoryController::class);
        Route::resource('/object', ObjectDataController::class);
        Route::resource('/monitoring', MonitoringController::class);
        Route::resource('/input-monitoring', InputController::class);
        Route::resource('/option-input-monitoring', OptionController::class);
        Route::resource('/image-monitoring', ImageController::class);
        Route::resource('/user', UserController::class);
        Route::resource('/team', TeamController::class);
        Route::post('/team/{id}/add/employee', [TeamController::class, 'addEmployee']);
        Route::post('/team/{id}/remove/employee', [TeamController::class, 'removeEmployee']);
        Route::post('/category-monitoring/{id}/add/object', [CategoryController::class, 'addObject']);
        Route::post('/category-monitoring/{id}/remove/object', [CategoryController::class, 'removeObject']);
    });
});
