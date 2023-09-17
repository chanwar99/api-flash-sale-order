<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Rute-rute untuk ProductController
Route::resource('products', ProductController::class);

// Rute-rute untuk OrderController
Route::resource('orders', OrderController::class);

// Rute untuk menambah produk ke order
Route::post('orders/add-product', [OrderController::class, 'addProductToOrder']);