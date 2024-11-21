<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect('/');
    }
    public function  getProductDetail($slug)
    {
        // whereHas là lọc các bản ghi của model chính dựa trên điều kiện của mối quan hệ
        // whereHas ('Định nghĩa trong model = Eloquent', callback $query thay cho đối tương Eloquent   )
            // dd($slug);
        $productDetail = Product::query()->where('slug', $slug)->firstOrFail();
        //Lấy các ảnh phụ thuộc sản phẩm
        $galleriesOfProduct = $productDetail->galleries->pluck('image');
        // dd($galleriesOfProduct);
        //Lấy các tên danh mục mà sản phẩm đó thuộc nó
        $categoriesOfProduct = Category::whereHas('CategoryProducts', function ($query) use ($productDetail) {
            $query->where('product_id',$productDetail->id);
        })->pluck('name')->toArray();
        // implode biến mảng thành chuỗi
        // Sản phẩm liên quan
        $relatedProducts = Product::query()->where('id', '<>', $productDetail->id)->get();
        // Sản phẩm cùng danh mục
        $getProductsByCategory = Product::query()->whereHas('ProductCategories', function ($query) use ($productDetail) {
                    $query->where('category_id', $productDetail->ProductCategories->first()->category_id);
                })->where('id', '<>', $productDetail->id)->get();
        // dd($getProductsByCategory);
        $getListComments = Comment::where('product_id',$productDetail->id)->with('user')->get();
        // dd($getListComments);
        
        return view('productDetail', compact('productDetail','galleriesOfProduct','categoriesOfProduct', 'relatedProducts', 'getProductsByCategory','getListComments'));
    }
    
}
