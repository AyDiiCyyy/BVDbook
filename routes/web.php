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
    // Route::get('/', DashboardController::class,'index')->name('dashboard');
    Route::prefix('category')->as('category.')->group(function (){
    });
    Route::prefix('product')->as('product.')->group(function (){
        Route::get('/',[ProductController::class,'index'])->name('index');
        Route::get('/create',[ProductController::class,'create'])->name('create');
        Route::post('/create',[ProductController::class,'store'])->name('store');
        Route::get('/edit/{slug}',[ProductController::class,'edit'])->name('edit');
        Route::get('/edit/{slug}',[ProductController::class,'update'])->name('update');
        Route::delete('/destroy',[ProductController::class,'destroy'])->name('destroy');
    });
});