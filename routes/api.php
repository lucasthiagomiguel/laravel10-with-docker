<?php

use App\Http\Controllers\ClientController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/hello', function () {
    return response()->json(['message' => 'Hello']);
});



Route::resource('clients', ClientController::class);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);

Route::put('/teste/{id}', function () {
    return 'teste';
});

Route::post('/upload', [ProductController::class, 'update']);

Route::middleware('api')->group(function () {
    Route::post('/clients', [ClientController::class, 'store']);
});
