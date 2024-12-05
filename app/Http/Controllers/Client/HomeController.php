<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Order;
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
                    ->pluck('order_details.product_id');
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
        
        $bestSellers = Product::select('products.*')
        ->join('order_details', 'products.id', '=', 'order_details.product_id')
        ->where('products.active', 1) 
        ->where('products.quantity', '>', 0) 
        ->groupBy('products.id') 
        ->orderByRaw('SUM(order_details.quantity) DESC') 
        ->limit(10) 
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

// Comment

        $getListComments = Comment::where('product_id', $productDetail->id)->with('user')->get();
        // dd($getListComments);
// Lấy thông tin đơn hàng của người dùng (giả sử bạn có một cách để xác định người dùng hiện tại)
$order = Order::where('user_id', auth()->id()) // Lấy đơn hàng của người dùng hiện tại
->where('status', 4) // Đơn hàng đã giao
->where('payment_status', 1) // Đã thanh toán
->first(); // Lấy đơn hàng đầu tiên thỏa mãn điều kiện

// Lấy thông tin chi tiết đơn hàng liên quan đến sản phẩm
$orderDetail = null;
if ($order) {
$orderDetail = OrderDetail::where('order_id', $order->id)
                ->where('product_id', $productDetail->id)
                ->first(); // Lấy chi tiết đơn hàng cho sản phẩm
}

return view('client.partials.productdetail', compact('productDetail', 'galleriesOfProduct', 'categoriesOfProduct', 'relatedProducts', 'getProductsByCategory', 'getListComments', 'orderDetail', 'order'));
    }
    public function comment(Request $request, $productId)
    {
        
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
    
        
        $product = Product::findOrFail($productId);
    
        
        $order = Order::where('user_id', auth()->id())
                      ->where('status', 4) 
                      ->where('payment_status', 1) 
                      ->first();
    
        if ($order) {
            $orderDetail = OrderDetail::where('order_id', $order->id)
                                      ->where('product_id', $product->id)
                                      ->first();
    
            
            if ($orderDetail && $orderDetail->active == 0) {
                // Tạo bình luận
                $comment = Comment::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'content' => $request->content,
                ]);
    
                
                $orderDetail->active = 1; 
                $orderDetail->save();
    
               
                return response()->json([
                    'success' => true,
                    'comment' => $comment,
                    'user' => $comment->user,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã bình luận cho sản phẩm này rồi.',
                ], 400); // Trả về mã lỗi 400
            }
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy đơn hàng phù hợp.',
        ], 400); // Trả về mã lỗi 400
    }
    public function getReviewCount($id)
{
    $count = Comment::where('product_id', $id)->count();
    return response()->json(['count' => $count]);
}
}
