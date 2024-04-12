<?php

use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Admin\TypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// #GUEST
Route::name('guest.')->group(function () {
  Route::get('/', [GuestController::class, 'index'])->name('index');
});

// #AUTH
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
  // GENERAL
  Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

  // PROJECTS
  Route::resource('projects', ProjectController::class);
  Route::delete('projects/{project}/destroy-img', [ProjectController::class, 'destroyImg'])->name('projects.destroy-img');

  // TYPES
  Route::resource('types', TypeController::class)->middleware('role.admin')->except(['index', 'show']);
  Route::resource('types', TypeController::class)->only(['index', 'show']);

  // TECHNOLOGIES
  Route::resource('technologies', TypeController::class)->middleware('role.admin')->except(['index', 'show']);
  Route::resource('technologies', TypeController::class)->only(['index', 'show']);
});

require __DIR__ . '/auth.php';