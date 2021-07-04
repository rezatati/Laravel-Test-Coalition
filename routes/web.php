<?php

use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});




Route::middleware(['auth:sanctum', 'verified'])->get('/products', function () {
    return Inertia::render('myPages/products');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/add-product/{id}', function () {
    return Inertia::render('myPages/addProduct');
})->name('product.add');
Route::middleware(['auth:sanctum', 'verified'])->get('/get-product/{id}', [ProductController::class, "getProduct"])->name('product.get');

Route::middleware(['auth:sanctum', 'verified'])->post('/products', [ProductController::class, "productsList"])->name('products.list.post');
Route::middleware(['auth:sanctum', 'verified'])->post('/add-product', [ProductController::class, "saveProduct"])->name('product.save');