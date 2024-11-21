<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    const PAGINATION = 10;

    public function proCate($slug) {
        $category = Category::where('slug',$slug)->firstOrFail();
        $products = $category-> CategoryProducts()->paginate(self::PAGINATION);
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

}
