<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\MyAccountController;
use App\Http\Controllers\Client\OrderCController;
use App\Http\Controllers\Client\VoucherController as ClientVoucherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Đăng nhập, đăng ký
Auth::routes();




// Sử dụng middleware `auth` để yêu cầu đăng nhập trước khi truy cập vào các route admin
Route::middleware(['auth', 'admin.role'])->group(function () {

    // Routes cho phần admin
    Route::prefix('admin')->as('admin.')->group(function () {
        Route::prefix('statistic')->as('statistic.')->group(function () {
            Route::get('/', [StatsController::class, 'index'])->name('index');
            Route::post('/revenue', [StatsController::class, 'getRevenue'])->name('getRevenue');
        });
        // Routes cho quản lý slide
        Route::prefix('slide')->as('slide.')->group(function () {
            Route::get('/', [SlideController::class, 'index'])->name('index');
            Route::get('/create', [SlideController::class, 'create'])->name('create');
            Route::post('/store', [SlideController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [SlideController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [SlideController::class, 'update'])->name('update');
            Route::post('/changeActive', [SlideController::class, 'changeActive'])->name('changeActive');
            Route::post('/changeOrder', [SlideController::class, 'changeOrder'])->name('changeOrder');
        });

        // Routes cho quản lý danh mục
        Route::prefix('category')->as('category.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/store', [CategoryController::class, 'store'])->name('store');
            Route::get('/show/{id}', [CategoryController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{id}/destroy', [CategoryController::class, 'destroy'])->name('destroy');
            Route::post('/changeActive', [CategoryController::class, 'changeActive'])->name('changeActive');
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
            Route::get('/show/{id}', 'show')->name('show');
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
            Route::delete('/{id}/destroy', [UserController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('order')->as('order.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::post('/change-status', [OrderController::class, 'changeActive'])->name('changeActive');
            Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
        });   
        Route::prefix('comments')->as('comments.')->group(function () {
            Route::get('/', [CommentController::class, 'index'])->name('index');
            Route::get('/show/{id}', [CommentController::class, 'show'])->name('show');
            Route::post('/{id}', [CommentController::class, 'destroy'])->name('destroy');
        });
    });
});

// router client
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('danhmuc/{slug}', [HomeController::class, 'proCate'])->name('danhmucSanpham');
Route::get('/about', function () {
    return view('client.partials.gioithieu');
})->name('about');
//Sản phẩm chi tiết
Route::get('/sanpham/{slug}', [HomeController::class, 'getProductDetail'])->name('productDetail');
Route::post('/sanpham/{slug}', [HomeController::class, 'getProductDetail'])->name('productDetail');
Route::post('product/comment/{productId}', [HomeController::class, 'comment'])->name('client.product.comment');

// Route cho trang liên hệ, sử dụng ContactController
Route::get('/contact', [ContactController::class, 'contact'])->name('contact.index');

// Giỏ hàng
Route::middleware('auth')->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/get', [CartController::class, 'getCart'])->name('cart.get');
    Route::get('/cart/quantity', [CartController::class, 'getCartQuantity'])->name('cart.quantity');
});





//thanh toán
Route::middleware('auth')->group(function () {
    Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('checkvoucher', [CheckoutController::class, 'checkvoucher'])->name('checkvoucher');
    Route::post('usevoucher', [CheckoutController::class, 'usevoucher'])->name('usevoucher');
    Route::post('pay', [CheckoutController::class, 'pay'])->name('pay');
    Route::get('check', [CheckoutController::class, 'check'])->name('check');
    Route::post('repayment/{id}', [OrderCController::class, 'repayment'])->name('repayment');
    Route::get('account/voucher', [ClientVoucherController::class, 'index'])->name('voucher');
    Route::get('account/myvoucher', [ClientVoucherController::class, 'list'])->name('myvoucher');
    Route::post('save_input', [ClientVoucherController::class, 'save_input'])->name('save_input');
    Route::post('save', [ClientVoucherController::class, 'save'])->name('save');
});
//account
Route::middleware('auth')->group(function () {
    Route::get('account', [MyAccountController::class, 'index'])->name('my-account');
    Route::get('account/update-profile', [MyAccountController::class, 'editProfile'])->name('client.account.editProfile.form');
    Route::post('account/update-profile', [MyAccountController::class, 'updateProfile'])->name('client.account.update-profile');
    Route::get('account/change-password', [MyAccountController::class, 'showChangePasswordForm'])->name('client.account.change-password.form');
    Route::post('account/change-password', [MyAccountController::class, 'changePassword'])->name('client.account.change-password');
    Route::put('account/update-password', [MyAccountController::class, 'updatePassword'])->name('client.account.update-password');
    Route::get('account/orders', [OrderCController::class, 'all'])->name('client.account.orders');
    Route::get('account/order/{order}', [MyAccountController::class, 'showOrderDetail'])->name('client.account.order-detail');
    Route::patch('orders/{orderId}/cancel', [MyAccountController::class, 'cancelOrder'])->name('client.orders.cancel');





    Route::prefix('account/orders')->as('client.account.orders.')->controller(OrderCController::class)->group(function () {
        Route::get('waiting', 'waiting')->name('waiting');
        Route::get('transport', 'transport')->name('transport');
        Route::get('waitCancel', 'waitCancel')->name('waitCancel');
        Route::get('complete', 'complete')->name('complete');
        Route::get('canceled', 'canceled')->name('canceled');
        Route::post('cancel/{id}', 'cancel')->name('cancel');
    });
});
