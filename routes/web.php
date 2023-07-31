<?php

use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\ProjectsController;
use App\Http\Controllers\Admin\TicketsController;
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
    return Inertia::render('Auth/Login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth']], function () {
    /* ====== Companies =======*/
    Route::resource('companies', CompaniesController::class);
    /* ====== Projects =======*/
    Route::resource('projects', ProjectsController::class);
    /* ====== Tickets =======*/
    Route::resource('tickets', TicketsController::class);
});

require __DIR__.'/auth.php';