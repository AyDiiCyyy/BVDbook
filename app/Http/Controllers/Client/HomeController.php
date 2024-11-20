<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    const PAGINATION = 8;
    public function index() {
        $product_noibat = Product::query()->where('best',1)->orderBy('order')->limit(10)->get();
        $product2 = $product_noibat->chunk(2);  // sản phẩm nổi bật

        $product_sale = Product::query()
        ->select('*',DB::raw('((price - sale) / price * 100) as discount'))
        ->where('sale','!=',null)
        ->orderBy('discount','desc')
        ->limit(5)->get(); // sản phẩm có giảm giá cao nhất

        $product_new = Product::query()->orderBy('id','desc')->limit(20)->get();
        $product_new = $product_new->chunk(2);
        return view('client.page.index',compact('product2','product_sale','product_new'));
    }

    public function proCate($slug) {
        $category=Category::where('slug',$slug)->firstOrFail();
        $products = $category->CategoryProducts()->paginate(self::PAGINATION);
        // dd($products);
        return view('client.page.productCategory',compact('category','products'));
    }
}
