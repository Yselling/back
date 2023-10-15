<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth routes
Route::post('/register', [AuthController::class, 'register']);

// Gender routes
//Route::group(['prefix' => 'genders', 'middleware' => 'auth:sanctum'], function () {
Route::group(['prefix' => 'genders'], function () {
    Route::get('/', [GenderController::class, 'index']);
});


