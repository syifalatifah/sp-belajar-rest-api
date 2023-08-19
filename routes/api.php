<?php

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

use App\Http\Controllers\UserController;
Route::post('/login', [UserController::class, 'login']);
Route::middleware(['jwt-auth'])->group(function(){
    Route::post('/product',[ProductController::class,'store']);
    Route::get('/product',[ProductController::class,'showAll']);
    Route::get('/product/{id}',[ProductController::class,'showById']);
    Route::get('/product/search/product_name={product_name}',[ProductController::class,'showByName']);
    Route::put('/product/{id}',[ProductController::class,'update']);
    Route::detele('/product/{id}',[ProductController::class,'delete']);
    
});

//Panggil ProductController sebagai object
use App\Http\Controllers\ProductController;



//Buat router untuk menambahkan data product

