<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VoucherController;
use Illuminate\Support\Facades\Route;

// Đăng nhập, đăng ký
Auth::routes();

// Route cho trang chủ người dùng sau khi đăng nhập
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Trang chính của client
Route::get('/', function () {
    return view('client.layouts');
});
Route::get('/about', function () {
    return view('client.partials.gioithieu');
});

// Sử dụng middleware `auth` để yêu cầu đăng nhập trước khi truy cập vào các route admin
Route::middleware(['auth', 'admin.role'])->group(function () {

    // Routes cho phần admin
    Route::prefix('admin')->as('admin.')->group(function () {

        // Routes cho quản lý danh mục
        Route::prefix('category')->as('category.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/store', [CategoryController::class, 'store'])->name('store');
            Route::get('/show/{id}', [CategoryController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{id}/destroy', [CategoryController::class, 'destroy'])->name('destroy');
        });

        // Routes cho quản lý sản phẩm
        Route::prefix('product')->as('product.')->controller(ProductController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/changeBest', 'changeBest')->name('changeBest');
            Route::post('/changeActive', 'changeActive')->name('changeActive');
            Route::post('/changeOrder', 'changeOrder')->name('changeOrder');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

        // Trang chính admin
        Route::get('/', function () {
            return view('layouts.admin');
        })->name('dashboard');

        // Route view `table` cho sản phẩm mà không liên quan đến ProductController
        Route::get('/product/table', function () {
            return view('admin.products.table');
        })->name('product.table');

        // Route view `form` cho sản phẩm mà không liên quan đến ProductController
        Route::get('/product/form', function () {
            return view('admin.products.form');
        })->name('product.form');

        // Routes cho quản lý voucher
        Route::resource('vouchers', VoucherController::class)->names([
            'index' => 'vouchers.index',
            'create' => 'vouchers.create',
            'store' => 'vouchers.store',
            'show' => 'vouchers.show',
            'edit' => 'vouchers.edit',
            'update' => 'vouchers.update',
            'destroy' => 'vouchers.destroy',
        ]);

        Route::patch('/vouchers/{id}/toggle-status', [VoucherController::class, 'toggleStatus'])->name('vouchers.toggleStatus');
    });

});



