<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\GenderController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Api\CategoryController;

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
    Route::post('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::group(['prefix' => 'carts'], function () {
        Route::get('/my-cart', [CartController::class, 'showMyCart'])->name('carts.show-my-cart');
        Route::post('/add-product', [CartController::class, 'addProductToCart'])->name('carts.add-product');
        Route::post('/update-product-amount', [CartController::class, 'updateProductAmount'])->name('carts.update-product-amount');
        Route::post('/decrement-product', [CartController::class, 'decrementProduct'])->name('carts.decrement-product');
        Route::post('/remove-product', [CartController::class, 'removeProduct'])->name('carts.remove-product');
        Route::delete('/empty', [CartController::class, 'empty'])->name('carts.empty');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('carts.checkout');
    });
});
Route::post('/stripe/webhook', [WebhookController::class, 'stripeWebhook'])->name('stripe.webhook');

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
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
