<?php

use App\Http\Controllers\Web\Information\InformationController;
use App\Http\Controllers\Web\Monitoring\CategoryController;
use App\Http\Controllers\Web\Monitoring\InputController;
use App\Http\Controllers\Web\Monitoring\MonitoringController;
use App\Http\Controllers\Web\Monitoring\ObjectController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\Team\TeamController;
use App\Http\Controllers\Web\User\UserController as UserUserController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\User\Employee\EmployeeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('under/construction', [PageController::class, 'index'])->name('under.construction');
Route::post('/app/login', [UserController::class, 'login'])->name('app.login');
Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/verify', [UserController::class, 'indexVerification'])->name('index.verification');
    Route::post('/verify', [UserController::class, 'verification'])->name('app.verification');
    Route::namespace('App')->prefix('app')->name('app.')->group(function() {
        Route::resource('/monitoring/category', CategoryController::class);
        Route::resource('/monitoring/object', ObjectController::class);
        Route::resource('/monitoring/input', InputController::class);
        Route::resource('/monitoring', MonitoringController::class);
        Route::resource('/information', InformationController::class);
        Route::get('/information/download/data', [InformationController::class, 'download'])->name('information.download');
        Route::resource('/user', UserUserController::class);
        Route::resource('/monitoring/image', ImageController::class);
        Route::get('/monitoring/download/image', [ImageController::class, 'downloadImage'])->name('image.download');
        Route::get('/monitoring/export/excel', [MonitoringController::class, 'export_excel'])->name('monitoring.export-excel');
        Route::get('/monitoring/export/{id}/pdf', [MonitoringController::class, 'export_pdf'])->name('monitoring.export-pdf');
        Route::resource('/employee', EmployeeController::class);
        Route::resource('/team', TeamController::class);
        Route::resource('/monitoring/input-option', InputOptionController::class);
        Route::resource('/monitoring/input/value', InputValueController::class);
        Route::get('/monitoring/input-download/image', [InputController::class, 'download'])->name('input-image.download');
        Route::get('/monitoring/input-download/value', [InputValueController::class, 'download'])->name('value.download');
        Route::post('/team/{id}/add/employee', [TeamController::class, 'addEmployee'])->name('team.add.employee');
        Route::post('/team/{id}/remove/employee', [TeamController::class, 'removeEmployee'])->name('team.remove.employee');
        Route::get('/export/team', [TeamController::class, 'exportExcel'])->name('team.export-excel');
        Route::post('/import/team', [TeamController::class, 'importExcel'])->name('team.import-excel');
        Route::delete('/delete/all/team', [TeamController::class, 'destroyAll'])->name('team.delete-all');
        Route::get('/export/employee', [EmployeeController::class, 'exportExcel'])->name('employee.export-excel');
        Route::post('/import/employee', [EmployeeController::class, 'importExcel'])->name('employee.import-excel');
        Route::delete('/delete/all/employee', [EmployeeController::class, 'destroyAll'])->name('employee.delete-all');
    });
});


// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');
