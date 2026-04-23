<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| Accessible to ALL users (no authentication required).
|
| Functional Requirements:
| - View all projects
| - View project details
| - Search/filter projects
| - Register a new user
| - Login
|--------------------------------------------------------------------------
*/

// Redirect homepage → public project list
Route::get('/', fn() => redirect()->route('projects.index'));

// Public: View all projects
Route::get('/projects', [ProjectController::class, 'index'])
    ->name('projects.index');

// Public: Login form
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

// Public: Login submission
Route::post('/login', [AuthController::class, 'login']);

// Public: Registration form
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

// Public: Registration submission
Route::post('/register', [AuthController::class, 'register']);

// Public: Logout (POST only for security)
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Protected Routes (Authentication Required)
|--------------------------------------------------------------------------
| Functional Requirements for authenticated users:
| - Add a new project
| - Update their own projects
| - Delete their own projects
| - View dashboard
|
| Security:
| - 'auth' middleware enforces login
| - Authorisation checks inside ProjectController ensure users can only
|   modify their own projects (via uid foreign key).
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard (summary of user's projects)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------
    | Project Management (CRUD)
    |--------------------------------------------------------------
    | NOTE:
    | /projects/create MUST be defined BEFORE /projects/{project}
    | to prevent Laravel treating "create" as a project ID.
    |--------------------------------------------------------------
    */

    // Create project form
    Route::get('/projects/create', [ProjectController::class, 'create'])
        ->name('projects.create');

    // Store new project
    Route::post('/projects', [ProjectController::class, 'store'])
        ->name('projects.store');

    // Edit project form
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])
        ->name('projects.edit');

    // Update project
    Route::put('/projects/{project}', [ProjectController::class, 'update'])
        ->name('projects.update');

    // Delete project
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])
        ->name('projects.destroy');

    // Reports page (SQL aggregation + analytics)
    Route::get('/reports', [ReportsController::class, 'index'])
        ->name('reports.index');
});


/*
|--------------------------------------------------------------------------
| Public Dynamic Route (Must Come Last)
|--------------------------------------------------------------------------
| Public: View project details (end date, phase, user email).
|
| IMPORTANT:
| Placed AFTER /projects/create and CRUD routes to avoid conflicts.
|--------------------------------------------------------------------------
*/

Route::get('/projects/{project}', [ProjectController::class, 'show'])
    ->name('projects.show');
