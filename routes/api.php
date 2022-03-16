<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

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

Route::get('/product', [ProductsController::class, 'index']);
Route::post('/product',[ProductsController::class, 'store']);
Route::get('/product/search/{name}',[ProductsController::class, 'search']);
Route::put('/product/{id}',[ProductsController::class, 'update']);
Route::delete('/product/{id}',[ProductsController::class, 'destroy']);
Route::get('/product/{id}',[ProductsController::class, 'show']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



