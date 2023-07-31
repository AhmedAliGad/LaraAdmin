<?php

use App\Http\Controllers\Admin\CloseReasonsController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\PrioritiesController;
use App\Http\Controllers\Admin\ProjectsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StatusesController;
use App\Http\Controllers\Admin\SupportTeamsController;
use App\Http\Controllers\Admin\TicketsController;
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

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::group(['middleware' => ['auth']], function () {
    /* ====== Support Teams =======*/
    Route::resource('support_teams', SupportTeamsController::class);
    /* ====== Companies =======*/
    Route::resource('companies', CompaniesController::class);
    /* ====== Projects =======*/
    Route::resource('projects', ProjectsController::class);
    /* ====== Tickets =======*/
    Route::resource('tickets', TicketsController::class);
    /* ====== Statuses =======*/
    Route::resource('statuses', StatusesController::class, ['except' => 'show']);
    /* ====== Priorities =======*/
    Route::resource('priorities', PrioritiesController::class, ['except' => 'show']);
    /* ====== Close Reasons =======*/
    Route::resource('close_reasons', CloseReasonsController::class, ['except' => 'show']);
    /* ====== Settings =======*/
    Route::name('settings.edit')->get('settings/edit', [SettingsController::class, 'edit']);
    Route::name('settings_update')->put('settings/edit', [SettingsController::class, 'update']);
});

require __DIR__.'/auth.php';
