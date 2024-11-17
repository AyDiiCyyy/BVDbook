<?php



use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Client\HomeController;
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
    Route::prefix('category')->as('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/show/{id}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [CategoryController::class, 'destroy'])->name('destroy');
    });
});


Route::prefix('admin')->as('admin.')->group(function(){
    Route::prefix('category')->as('category.')->group(function (){

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
Route::patch('/admin/vouchers/{id}/toggle-status', [VoucherController::class, 'toggleStatus'])->name('vouchers.toggleStatus');



// router client
Route::get('/',[HomeController::class,'index']);
Route::get('/{slug}',[HomeController::class,'proCate']);