<?php



use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\HomeController;
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


Route::prefix('admin')->as('admin.')->group(function () {
   
});


Route::prefix('admin')->as('admin.')->group(function(){
    Route::prefix('category')->as('category.')->group(function (){
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/store', [CategoryController::class, 'store'])->name('store');
            Route::get('/show/{id}', [CategoryController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy'); 
    });
    Route::prefix('product')->as('product.')->controller(ProductController::class)->group(function (){
        Route::get('/','index')->name('index');
        Route::post('/changeBest', 'changeBest')->name('changeBest');
        Route::post('/changeActive', 'changeActive')->name('changeActive');
        Route::post('/changeOrder', 'changeOrder')->name('changeOrder');
        Route::get('/create','create')->name('create');
        Route::post('/store','store')->name('store');
        Route::get('/edit/{id}','edit')->name('edit');
        Route::post('/update/{id}','update')->name('update');
        Route::delete('/destroy/{id}','destroy')->name('destroy');
    });
    
    Route::prefix('voucher')->as('voucher.')->controller(VoucherController::class)->group(function (){
        Route::get('/','index')->name('index');
        Route::get('/create',  'create' )->name('create');
        Route::post('/store','store')->name('store');
        Route::get('/edit/{id}','edit')->name('edit');
        Route::post('/update/{id}','update')->name('update');
        Route::delete('/destroy/{id}','destroy')->name('destroy');
    });

});


Route::get('/sanpham/{slug}',[HomeController::class,'getProductDetail'])->name('productDetail');

Route::get('admin', function () {
    return view('layouts.admin');
});
Route::get('product', function () {
    return view('admin.products.table');
})->name("product");
Route::get('form', function () {
    return view('admin.products.form');
})->name("form");


