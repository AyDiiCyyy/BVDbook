<?php

use App\Http\Controllers\Admin\VoucherController;
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

Route::get('/', function () {
    return view('client.layouts');
});

Route::prefix('admin')->as('admin.')->group(function(){
    Route::prefix('category')->as('category.')->group(function (){

    });
});
Route::get('admin', function () {
    return view('layouts.admin');
});
Route::get('product', function () {
    return view('admin.products.table');
})->name("product");
Route::get('form', function () {
    return view('admin.products.form');
})->name("form");

Route::resource('vouchers', VoucherController::class);
Route::get('vouchers/{id}/restore', [VoucherController::class, 'restore'])->name('vouchers.restore');

