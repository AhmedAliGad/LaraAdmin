<?php

use App\Http\Controllers\Admin\CloseReasonsController;
use App\Http\Controllers\Admin\CommentsController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\PrioritiesController;
use App\Http\Controllers\Admin\ProjectsController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StatusesController;
use App\Http\Controllers\Admin\SupportTeamsController;
use App\Http\Controllers\Admin\TicketsController;
use App\Models\Company;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\Meta;
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
    Meta::addMeta('title', 'Dashboard');
    Meta::addMeta('description', 'FNDEV Ticket System Dashboard');
    return Inertia::render('Dashboard', [
        'tickets' => Ticket::latest()->limit(10)
            ->with(['status:id,name_en', 'category:id,name_en', 'priority:id,name_en', 'project:id,name'])->get(),
        'total_clients' => User::whereIn('role', ['client', 'supervisor'])->count(),
        'total_companies' => Company::count(),
        'total_projects' => Project::count(),
        'total_tickets' => Ticket::count()
    ]);
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
    Route::get('projects_list', [ProjectsController::class, 'projectsList'])->name('projects_list');
    /* ====== Tickets =======*/
    Route::resource('tickets', TicketsController::class);
    Route::get('/tickets_report', [TicketsController::class, 'reports'])->name('tickets.reports');
    Route::get('/tickets_export', [TicketsController::class, 'export'])->name('tickets.export');
    /* ====== Comments =======*/
    Route::resource('tickets.comments', CommentsController::class);
    /* ====== Statuses =======*/
    Route::resource('statuses', StatusesController::class, ['except' => 'show']);
    /* ====== Priorities =======*/
    Route::resource('priorities', PrioritiesController::class, ['except' => 'show']);
    /* ====== Close Reasons =======*/
    Route::resource('close_reasons', CloseReasonsController::class, ['except' => 'show']);
    /* ====== Settings =======*/
    Route::name('settings.edit')->get('settings/edit', [SettingsController::class, 'edit']);
    Route::name('settings_update')->put('settings/edit', [SettingsController::class, 'update']);
    /* ====== Settings =======*/
    Route::name('tickets_chart')->get('tickets_chart', [ReportsController::class, 'ticketsChart']);
    Route::name('company_chart')->get('company_chart', [ReportsController::class, 'companyChart']);
});

require __DIR__.'/auth.php';
