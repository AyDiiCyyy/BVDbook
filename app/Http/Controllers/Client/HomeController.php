<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    const PAGINATION = 10;

    public function proCate($slug, Request $request)
    {
        $sortBy = $request->query('sort_by');
        $category = Category::where('slug', $slug)->firstOrFail();
        $productId = $category->CategoryProducts()->pluck('product_id');
        $productsSortBy = Product::query()->whereIn('id', $productId);
        // Áp dụng sắp xếp nếu có
        if ($sortBy) {
            switch ($sortBy) {
                case 'name_asc':
                    $productsSortBy->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $productsSortBy->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $productsSortBy->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $productsSortBy->orderBy('price', 'desc');
                    break;
                case 'created_desc':
                    $productsSortBy->orderBy('created_at', 'desc');
                    break;
                case 'created_asc':
                    $productsSortBy->orderBy('created_at', 'asc');
                    break;
                case 'discount_desc':
                    $productsSortBy ->selectRaw('*, (price - sale) / price * 100 as discount_percentage')
                    ->orderBy('discount_percentage', 'desc');
                    break;
                case 'popular':
                   $popular = OrderDetail::query()->join('products', 'order_details.product_id', '=', 'products.id')
                    ->join('orders', 'order_details.order_id', '=', 'orders.id')
                    ->select('order_details.product_id',DB::raw('SUM(order_details.quantity) as sold_quantity'),)
                    ->where('orders.status', 4)
                    ->groupBy('order_details.product_id')
                    ->orderByDesc('sold_quantity')
                    ->pluck('order_de   tails.product_id');
                    $productsSortBy->whereIn('id', $popular);
                    break;
                default:
                $productsSortBy->orderBy('created_at', 'desc');
                    break;
            }
        }
        $products = $productsSortBy->paginate(self::PAGINATION);
        return view('client.page.productCategory', compact('category', 'products', 'sortBy', 'slug'));
    }
   
    public function index()
    {
        //sản phẩm nổi bật 
        $product_noibat = Product::query()
            ->where('best', 1)
            ->where('active', 1)
            ->where('quantity', '>', 0)
            ->orderBy('order')
            ->limit(10)
            ->get();
        $product2 = $product_noibat->chunk(2);

        // Sản phẩm có giảm giá cao nhất
        $product_sale = Product::query()
            ->select('*', DB::raw('((price - sale) / price * 100) as discount'))
            ->where('sale', '!=', null)
            ->where('active', 1)
            ->where('quantity', '>', 0)
            ->orderBy('discount', 'desc')
            ->limit(5)
            ->get();

        // Sản phẩm mới nhất
        $product_new = Product::query()
            ->where('active', 1)
            ->where('quantity', '>', 0)
            ->orderBy('id', 'desc')
            ->limit(20)
            ->get();
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
        $bestSellers = Product::query()
            ->where('active', 1) // Chỉ lấy sản phẩm đang hoạt động
            ->where('quantity', '>', 0) // Chỉ lấy sản phẩm có số lượng lớn hơn 0
            ->orderBy('order', 'desc') // Sắp xếp theo số lượng đã bán
            ->limit(10) // Giới hạn số lượng sản phẩm
            ->get();


        return view('client.page.index', compact('product2', 'product_sale', 'product_new', 'categories', 'bestSellers'));
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
            $query->where('product_id', $productDetail->id);
        })->pluck('name')->toArray();
        // implode biến mảng thành chuỗi
        // Sản phẩm liên quan
        $relatedProducts = Product::query()->where('id', '<>', $productDetail->id)->get();
        // Sản phẩm cùng danh mục
        $getProductsByCategory = Product::query()->whereHas('ProductCategories', function ($query) use ($productDetail) {
            $query->where('category_id', $productDetail->ProductCategories?->first()?->category_id);
        })->where('id', '<>', $productDetail->id)->get();
        // dd($getProductsByCategory);
        $getListComments = Comment::where('product_id', $productDetail->id)->with('user')->get();
        // dd($getListComments);

        return view('client.partials.productdetail', compact('productDetail', 'galleriesOfProduct', 'categoriesOfProduct', 'relatedProducts', 'getProductsByCategory', 'getListComments'));
    }
}
