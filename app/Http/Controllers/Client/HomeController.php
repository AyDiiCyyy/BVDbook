<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    const PAGINATION = 10;

    public function proCate($slug) {
        $category = Category::where('slug',$slug)->firstOrFail();
        $productId = $category->CategoryProducts()->pluck('product_id');
        $products= Product::query()->whereIn('id',$productId)->paginate(self::PAGINATION);
        return view('client.page.productCategory', compact('category', 'products'));

    }

    public function index(){
        //sản phẩm nổi bật
        $product_noibat = Product::query()->where('best',1)->orderBy('order')->limit(10)->get();
        $product2 = $product_noibat ->chunk(2);

        //sản phẩm có giảm giá cao nhất
        $product_sale = Product::query()
        ->select('*', DB::raw('((price-sale)/price*100) as discount') )
        ->where('sale', '!=',null)
        ->orderBy('discount', 'desc')
        ->limit(5)->get();

        //sản phẩm mới nhất
        $product_new = Product::query()->orderBy('id', 'desc')->limit(20)->get();
        $product_new = $product_new->chunk(2);

        //danh mục phổ biến
        $categories = Category::query()
        ->select('categories.*', DB::raw('COUNT(category_products.product_id) as product_count'))
        ->leftJoin('category_products', 'categories.id', '=', 'category_products.category_id')
        ->groupBy('categories.id')
        ->orderByDesc('product_count')
        ->limit(5)
        ->get();
        $categories = $categories->chunk(2);


        return view('client.page.index', compact('product2', 'product_sale', 'product_new', 'categories'));


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

        return view('client.partials.productdetail', compact('productDetail','galleriesOfProduct','categoriesOfProduct', 'relatedProducts', 'getProductsByCategory','getListComments'));
    }

    
}
