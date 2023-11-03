<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmUsersController;
use App\Http\Controllers\AdmProductsController;

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
Route::view('/dashboard', 'dashboard');

// Admin Routes<
Route::get('/products', [AdmProductsController::class, 'index'])->name('adm.products.index');
Route::get('/products/{product}/edit', [AdmProductsController::class, 'edit'])->name('adm.products.edit');
Route::post('/products/{product}', [AdmProductsController::class, 'update'])->name('adm.products.update');
Route::get('/products/create', [AdmProductsController::class, 'create'])->name('adm.products.create');
Route::post('/products', [AdmProductsController::class, 'store'])->name('adm.products.store');
Route::post('/products/upc', [AdmProductsController::class, 'addUpc'])->name('adm.products.add-upc');

Route::get('/users', [AdmUsersController::class, 'index'])->name('adm.users.index');
Route::get('/users/{user}/edit', [AdmUsersController::class, 'edit'])->name('adm.users.edit');
Route::post('/users/{user}', [AdmUsersController::class, 'update'])->name('adm.users.update');

// Route::delete('/products/{product}', [AdmProductsController::class, 'destroy'])->name('adm.products.destroy');

