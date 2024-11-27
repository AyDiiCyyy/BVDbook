<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ContactController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Đăng nhập, đăng ký
Auth::routes();




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
        Route::resource('voucher', VoucherController::class)->names([
            'index' => 'voucher.index',
            'create' => 'voucher.create',
            'store' => 'voucher.store',
            'show' => 'voucher.show',
            'edit' => 'voucher.edit',
            'update' => 'voucher.update',
            'destroy' => 'voucher.destroy',
        ]);

        Route::patch('/voucher/{id}/toggle-status', [VoucherController::class, 'toggleStatus'])->name('voucher.toggleStatus');



        Route::prefix('user')->as('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('admin/user/change-active', [UserController::class, 'changeActive'])->name('changeActive');
   
            Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [UserController::class, 'update'])->name('update');
        
    
        });
        Route::prefix('order')->as('order.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::post('/change-status', [OrderController::class, 'changeActive'])->name('changeActive');
            Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
        });
    });

});









// router client
Route::get('/',[HomeController::class,'index'])->name('index');
Route::get('danhmuc/{slug}',[HomeController::class,'proCate'])->name('danhmucSanpham');
Route::get('/about', function () {
    return view('client.partials.gioithieu');
});
//Sản phẩm chi tiết
Route::get('/sanpham/{slug}',[HomeController::class,'getProductDetail'])->name('productDetail');

// Route cho trang liên hệ, sử dụng ContactController
Route::get('/contact', [ContactController::class, 'contact'])->name('contact.index');