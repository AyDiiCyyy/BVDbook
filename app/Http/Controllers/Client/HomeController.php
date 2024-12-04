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
                    $productsSortBy->selectRaw('*, (price - sale) / price * 100 as discount_percentage')
                        ->orderBy('discount_percentage', 'desc');
                    break;
                case 'popular':
                    // Lấy thông tin chi tiết về sản phẩm bán chạy nhất
                    $popular = OrderDetail::query()
                        ->join('products', 'order_details.product_id', '=', 'products.id')
                        ->join('orders', 'order_details.order_id', '=', 'orders.id')
                        ->select(
                            'products.name as product_name',
                            'order_details.product_id',
                            DB::raw('SUM(order_details.quantity) as sold_quantity'),
                            DB::raw('SUM(order_details.price * order_details.quantity) as total_revenue')
                        )
                        ->where('orders.status', 4)
                        ->groupBy('products.name', 'order_details.product_id')
                        ->orderByDesc('sold_quantity') // Sắp xếp theo số lượng bán giảm dần
                        ->pluck('order_details.product_id'); // Trả về danh sách product_id bán chạy nhất

                    // Lọc theo danh mục và độ phổ biến (sản phẩm bán chạy)
                    $productsSortBy->whereIn('id', $productId)   // Lọc theo danh mục
                        ->whereIn('id', $popular);    // Lọc theo sản phẩm bán chạy
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
        $product_noibat = Product::query()->where('best', 1)->orderBy('order')->limit(10)->get();
        $product2 = $product_noibat->chunk(2);

        //sản phẩm có giảm giá cao nhất 
        $product_sale = Product::query()
            ->select('*', DB::raw('((price-sale)/price*100) as discount'))
            ->where('sale', '!=', null)
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
