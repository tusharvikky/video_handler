<?php

use App\Http\Controllers\ProvidersController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('provider')->group(function() {
	Route::get('list', [ProvidersController::class, 'list']);
	Route::post('video', [ProvidersController::class, 'video']);
	Route::post('image', [ProvidersController::class, 'image']);
	Route::get('uploaded', [ProvidersController::class, 'uploaded']);
});

