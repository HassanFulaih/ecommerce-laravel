<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MedicalOrderController;
use App\Http\Controllers\CosmeticOrderController;
use App\Http\Controllers\UserFavoriteController;

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

//Route::resources('/products', ProductController::class);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);

Route::group(['middleware'=> ['auth:sanctum']], function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    
    Route::put('/userFavorites/{id}', [UserFavoriteController::class, 'update']);
    Route::get('/userFavorites', [UserFavoriteController::class, 'index']);
    
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    
    Route::post('/corders', [CosmeticOrderController::class, 'store']);
    Route::get('/corders/{id}', [CosmeticOrderController::class, 'show']);
    
    Route::post('/morders', [MedicalOrderController::class, 'store']);
    Route::get('/morders/{id}', [MedicalOrderController::class, 'show']);


    Route::put('/user/{id}', [AuthController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/user/{id}', [AuthController::class, 'destroy']);
});
