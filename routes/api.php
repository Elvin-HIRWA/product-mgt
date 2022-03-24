<?php
declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;

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


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});

Route::get('/product', [ProductsController::class, 'index'])->middleware("auth:sanctum");
Route::post('/product',[ProductsController::class, 'store'])->middleware("auth:sanctum");
Route::get('/product/search/{name}',[ProductsController::class, 'search'])->middleware("auth:sanctum");
Route::put('/product/{id}',[ProductsController::class, 'update'])->middleware("auth:sanctum");
Route::delete('/product/{id}',[ProductsController::class, 'destroy'])->middleware("auth:sanctum");
Route::get('/product/{id}',[ProductsController::class, 'show'])->middleware("auth:sanctum");
Route::post('/logout', [UserController::class, 'logout'])->middleware("auth:sanctum");