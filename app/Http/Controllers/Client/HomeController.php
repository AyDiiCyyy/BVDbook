<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Comment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Slide;
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
        $productsSortBy = Product::query()->whereIn('id', $productId)->where('active',1);
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
                    $popular = OrderDetail::query()->join('products', 'order_details.product_id', '=', 'products.id')
                        ->join('orders', 'order_details.order_id', '=', 'orders.id')
                        ->select('order_details.product_id', DB::raw('SUM(order_details.quantity) as sold_quantity'),)
                        ->where('orders.status', 4)
                        ->groupBy('order_details.product_id')
                        ->orderByDesc('sold_quantity')
                        ->pluck('order_details.product_id');
                    $productsSortBy->whereIn('id', $popular);
                    break;
                default:
                    $productsSortBy->orderBy('created_at', 'desc');
                    break;
            }
        }
        $totalProducts = $productsSortBy->count();
        $products = $productsSortBy->paginate(self::PAGINATION);
        return view('client.page.productCategory', compact('category', 'products', 'sortBy', 'slug','totalProducts'));
    }

    public function index()
    {
        //sản phẩm nổi bật
        $product_noibat = Product::query()
            ->where('best', 1)
            ->where('active', 1)
            ->where('quantity', '>', 0)
            ->orderBy('order')
            ->orderBy('id','desc')
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
            ->where('status', 1)
            ->leftJoin('category_products', 'categories.id', '=', 'category_products.category_id')
            ->groupBy('categories.id')
            ->orderByDesc('product_count')
            ->limit(6)
            ->get();
        $categories = $categories->chunk(2);

        $bestSellers = Product::select('products.*', DB::raw('SUM(order_details.quantity) as total_sold'))
        ->join('order_details', 'products.id', '=', 'order_details.product_id')
        ->join('orders', 'order_details.order_id', '=', 'orders.id')
        ->where('products.active', 1) 
        ->where('products.quantity', '>', 0) 
        ->where('orders.payment_status', 1) 
        ->where('orders.status', 4) 
        ->groupBy('products.id')
        ->orderBy('total_sold', 'DESC') 
        ->limit(10) 
        ->get();

        $slide = Slide::query()->where('active', 1)->orderBy('order')->get();
        return view('client.page.index', compact('product2', 'product_sale', 'product_new', 'categories', 'bestSellers', 'slide'));
    }

    public function  getProductDetail(Request $request, $slug)
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
        $relatedProducts = Product::query()->where('id', '<>', $productDetail->id)->where('released',$productDetail->released)->where('active',1)->limit(10)->get();
        // Sản phẩm cùng danh mục
        $getProductsByCategory = Product::query()->whereHas('ProductCategories', function ($query) use ($productDetail) {
            $query->where('category_id', $productDetail->ProductCategories?->first()?->category_id);
        })->where('id', '<>', $productDetail->id)->where('active',1)->limit(10)->get();
        // dd($getProductsByCategory);

        // Comment

        $getListComments = Comment::where('product_id', $productDetail->id)
        ->with('user')
        ->orderBy('id', 'desc')
        ->get();

        $orderDetail = OrderDetail::where('id', $request->oder_detail_id)
            ->where('active', 0)
            ->first();

        return view('client.partials.productdetail', compact('productDetail', 'galleriesOfProduct', 'categoriesOfProduct', 'relatedProducts', 'getProductsByCategory', 'getListComments', 'orderDetail'));
    }
    public function comment(Request $request, $productId)
{
    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    $orderDetail = OrderDetail::findOrFail($request->oder_detail_id);
    $product = Product::findOrFail($productId);

    if ($orderDetail && $orderDetail->active == 0 && $orderDetail->product_id == $productId) {
        $comment = Comment::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        $orderDetail->active = 1;
        $orderDetail->save();

        $commentCount = Comment::where('product_id', $productId);
        $commentCount = Comment::where('product_id', $productId)->count();


        $user = auth()->user();

        return response()->json([
            'content' => $comment->content,
            'user_name' => $user->name,
            'user_avatar' => $user->avatar ?? asset('assets/img/user2-160x160.jpg'),
            'created_at' => $comment->created_at->format('Y/m/d H:i:s'),
            'count' => $commentCount,
        ]);
    }

    return response()->json(['message' => 'Có lỗi xảy ra.'], 400);
}


    public function search (Request $request){
        $idCate= Category::where('slug',$request->category)->pluck('id')->first();
        $products = Product::query();
        if ($idCate) {
            $products->whereHas('productCategories', function ($query) use ($idCate) {
                $query->where('category_id', $idCate);
            });
        }
        if($request->keyw){
            $products = $products->where('name', 'LIKE', '%' . $request->keyw . '%');
        }
        $totalProducts = $products->where('active',1)->count();
        $products = $products->paginate(8);
        if($request->category){
            $products = $products -> appends('category', $request->category);
        }
        if($request->keyw){
            $products = $products -> appends('keyw', $request->keyw);
        }

        return view('client.page.productCategory',compact('products','totalProducts','request'));
    }

}
