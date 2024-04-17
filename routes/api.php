<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\TechnologyController;
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

Route::name('api.')->group(function () {
  Route::apiResource('projects', ProjectController::class)->only(['index', 'show']);
  Route::apiResource('types', TypeController::class)->only('index');
  Route::apiResource('technologies', TechnologyController::class)->only('index');
});