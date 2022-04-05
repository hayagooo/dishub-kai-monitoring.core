<?php

use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\UserController;
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

Route::post('/app/login', [UserController::class, 'login'])->name('app.login');
Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/verify', [UserController::class, 'indexVerification'])->name('index.verification');
    Route::post('/verify', [UserController::class, 'verification'])->name('app.verification');
});

Route::get('under/construction', [PageController::class, 'index'])->name('under.construction');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
