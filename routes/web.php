<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmUsersController;
use App\Http\Controllers\AdmProductsController;
use App\Http\Controllers\AdmCategoriesController;
use App\Http\Controllers\AdmGendersController;
use App\Http\Controllers\AdmOrdersController;

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


// Example Routes
Route::view('/', 'dashboard');

// Admin Routes<
Route::get('/products', [AdmProductsController::class, 'index'])->name('adm.products.index');
Route::get('/products/{product}/edit', [AdmProductsController::class, 'edit'])->name('adm.products.edit');
Route::get('/products/{product}/orders', [AdmProductsController::class, 'orders'])->name('adm.products.orders');
Route::post('/products/{product}', [AdmProductsController::class, 'update'])->name('adm.products.update');
Route::get('/products/create', [AdmProductsController::class, 'create'])->name('adm.products.create');
Route::post('/products', [AdmProductsController::class, 'store'])->name('adm.products.store');
Route::post('/test', [AdmProductsController::class, 'addUpc'])->name('adm.products.add-upc');

Route::get('/users', [AdmUsersController::class, 'index'])->name('adm.users.index');
Route::get('/users/{user}/edit', [AdmUsersController::class, 'edit'])->name('adm.users.edit');
Route::post('/users/{user}', [AdmUsersController::class, 'update'])->name('adm.users.update');
Route::get('/users/{user}/orders', [AdmUsersController::class, 'orders'])->name('adm.users.orders');
Route::get('/users/{user}/cart', [AdmUsersController::class, 'cart'])->name('adm.users.cart');

Route::get('/categories', [AdmCategoriesController::class, 'index'])->name('adm.categories.index');
Route::get('/categories/create', [AdmCategoriesController::class, 'create'])->name('adm.categories.create');
Route::post('/categories', [AdmCategoriesController::class, 'store'])->name('adm.categories.store');
Route::get('/categories/{category}/edit', [AdmCategoriesController::class, 'edit'])->name('adm.categories.edit');
Route::post('/categories/{category}', [AdmCategoriesController::class, 'update'])->name('adm.categories.update');
Route::get('/categories/{category}/products', [AdmCategoriesController::class, 'products'])->name('adm.categories.products');

Route::get('/genders', [AdmGendersController::class, 'index'])->name('adm.genders.index');
Route::get('/genders/create', [AdmGendersController::class, 'create'])->name('adm.genders.create');
Route::post('/genders', [AdmGendersController::class, 'store'])->name('adm.genders.store');
Route::get('/genders/{gender}/edit', [AdmGendersController::class, 'edit'])->name('adm.genders.edit');
Route::post('/genders/{gender}', [AdmGendersController::class, 'update'])->name('adm.genders.update');
Route::get('/genders/{gender}/users', [AdmGendersController::class, 'users'])->name('adm.genders.users');

Route::get('/orders', [AdmOrdersController::class, 'index'])->name('adm.orders.index');
Route::get('/orders/{order}/edit', [AdmOrdersController::class, 'edit'])->name('adm.orders.edit');
Route::post('/orders/{order}', [AdmOrdersController::class, 'update'])->name('adm.orders.update');
Route::get('/orders/{order}/users', [AdmOrdersController::class, 'products'])->name('adm.orders.products');











// Route::delete('/products/{product}', [AdmProductsController::class, 'destroy'])->name('adm.products.destroy');

