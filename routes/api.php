<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\ProductController;
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
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

// Gender routes
Route::group(['prefix' => 'genders'], function () {
    Route::get('/', [GenderController::class, 'index']);
    // add other crud
});

// Product routes
Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::put('/{product}', [ProductController::class, 'update']);
    Route::delete('/{product}', [ProductController::class, 'destroy']);
});

// voir son panier
// ajouter un/plusieurs nombre d'un article au panier
// supprimer un article du panier
// vider son panier
// modifier le nombre pour un article dans panier
// modifier le profil user
// supprimer son compte
// voir toutes les enchères en cours
// participer à l'enchère
// voir les participations à l enchère
// voir ses commandes passées



