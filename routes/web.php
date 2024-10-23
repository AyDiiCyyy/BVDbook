<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

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


Route::prefix('admin')->as('admin.')->group(function(){
    Route::prefix('category')->as('category.')->group(function (){

    });
    Route::prefix('product')->as('product.')->controller(ProductController::class)->group(function (){
        Route::get('/','index')->name('index');
        Route::get('create','create')->name('create');
        Route::post('/','store')->name('store');
        Route::post('/change-best','changeBest')->name('changeBest');
        Route::post('/change-active','changeActive')->name('changeActive');
        Route::post('/change-order','changeOrder')->name('changeOrder');
    });

});