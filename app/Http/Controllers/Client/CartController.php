<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request)
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng'], 401);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($validated['product_id']);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại'], 404);
        }

        $user = Auth::user();

        // Kiểm tra xem giỏ hàng có sản phẩm này chưa
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Nếu có rồi, cộng thêm số lượng
            $cartItem->quantity += $validated['quantity'];
            $cartItem->save();
        } else {
            // Nếu chưa có, tạo mới giỏ hàng
            $cartItem = Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $validated['quantity']
            ]);
        }

        // Tính lại tổng giá trị của giỏ hàng
        $totalPrice = $product->price * $cartItem->quantity;

        return response()->json([
            'status' => 'success',
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng',
            'cart_item' => $cartItem,  // In chi tiết của item đã cập nhật
            'total_price' => $totalPrice  // Trả về tổng giá trị của giỏ hàng
        ]);
    }

    public function showCart()
    {
        // Kiểm tra người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return redirect()->route('login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }

        $user = Auth::user();

        // Lấy tất cả các sản phẩm trong giỏ hàng của người dùng
        $cartItems = Cart::with('products') // Sử dụng 'products' đúng với tên quan hệ trong model
            ->where('user_id', $user->id)
            ->get();

        // Tính tổng giá trị giỏ hàng
        $subtotal = $cartItems->sum(function ($cartItem) {
            return $cartItem->products ? $cartItem->products->price * $cartItem->quantity : 0;
        });

        // Tính phí vận chuyển
        $shippingFee = 7;

        // Tính thuế
        $taxes = 0;

        // Tính tổng giá trị
        $totalPrice = $subtotal + $shippingFee + $taxes;

        // Truyền dữ liệu vào view
        return view('client.partials.cart', compact('cartItems', 'subtotal', 'shippingFee', 'taxes', 'totalPrice'));
    }

    public function updateCart(Request $request)
    {
        $cart_id = $request->get('cart_item_id');
        $quantity = $request->get('quantity');
        $action = $request->get('action');

        if (empty($cart_id) && empty($quantity)) {
            return response()->json([
                'status' => 'error'
            ]);
        }

        $cartItem = Cart::find($cart_id);

        // Kiểm tra xem sản phẩm có tồn tại trong giỏ không
        if (!$cartItem) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy sản phẩm trong giỏ']);
        }

        $product = Product::find($cartItem->product_id);

        // Cập nhật số lượng sản phẩm
        if ($action == "plus") {
            $cart_item_quantity = $quantity + 1;
        } else {
            $cart_item_quantity = $quantity - 1;
        }

        $cart_item_price = $product->price * $cart_item_quantity;

        $cartItem->quantity = $cart_item_quantity;
        $cartItem->total_price = $cart_item_price;
        $cartItem->save();

        $total_price = Cart::query()->where('status', 0)->where('user_id', Auth::id())->sum('total_price');

        // Cập nhật phí vận chuyển và thuế
        $shippingFee = 7;
        $taxes = 0;

        // Tính tổng giá trị giỏ hàng
        $totalPrice = $total_price + $shippingFee + $taxes;

        return response()->json([
            'status' => 'success',
            'cart_id' => $cart_id,
            'cart_item_quantity' => $cart_item_quantity,
            'cart_item_price' => $cart_item_price,
            'totalPrice' => number_format($totalPrice, 0, '.', '.')
        ]);
    }
}
