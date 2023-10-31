<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;

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

// contact
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Product routes
Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::group(['prefix' => 'carts'], function () {
        Route::get('/my-cart', [CartController::class, 'showMyCart'])->name('carts.show-my-cart');
        Route::post('/add-product', [CartController::class, 'addProductToCart'])->name('carts.add-product');
        Route::post('/update-product-amount', [CartController::class, 'updateProductAmount'])->name('carts.update-product-amount');
        Route::post('/decrement-product', [CartController::class, 'decrementProduct'])->name('carts.decrement-product');
        Route::post('/remove-product', [CartController::class, 'removeProduct'])->name('carts.remove-product');
        Route::delete('/empty', [CartController::class, 'empty'])->name('carts.empty');
    });
});

// USER
// modifier le profil user
// supprimer son compte

// BIDS
// voir toutes les enchères en cours
// participer à l'enchère
// voir les participations à l enchère

// ORDERS
// voir ses commandes passées

