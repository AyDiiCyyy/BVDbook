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

        if ($product->deleted_at) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm đã bị xóa bởi nhà cung cấp'], 400);
        }

        if ($product->quantity == 0) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm đã hết hàng'], 400);
        }

        if ($product->active == 0) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm hiện không hoạt động'], 400);
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

        $totalQuantity = Cart::where('user_id', $user->id)->sum('quantity');

        // Tính lại tổng giá trị của giỏ hàng
        $totalPrice = $product->price * $cartItem->quantity;

        return response()->json([
            'status' => 'success',
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng',
            'cart_item' => $cartItem,  // In chi tiết của item đã cập nhật
            'total_price' => $totalPrice,  // Trả về tổng giá trị của giỏ hàng
            'total_quantity' => $totalQuantity  // Trả về tổng số lượng giỏ hàng
        ]);
    }

    public function showCart()
    {
        // Kiểm tra người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return redirect()->route('login'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
        }
        $messages = $this->checkCartStatus();
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
        $shippingFee = 0;

        // Tính thuế
        $taxes = 0;

        // Tính tổng giá trị
        $totalPrice = $subtotal + $shippingFee + $taxes;

        // Truyền dữ liệu vào view
        return view('client.partials.cart', compact('cartItems', 'subtotal', 'shippingFee', 'taxes', 'totalPrice', 'messages'));
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
        $shippingFee = 0;
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

    public function remove(Request $request)
    {
        $cart_id = $request->get('cart_item_id');

        if (empty($cart_id)) {
            return response()->json(['status' => 'error', 'message' => 'ID sản phẩm không hợp lệ']);
        }

        // Lấy sản phẩm từ giỏ hàng
        $cartItem = Cart::find($cart_id);

        if (!$cartItem) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy sản phẩm trong giỏ']);
        }

        // Xóa sản phẩm khỏi giỏ hàng
        $cartItem->delete();

        // Lấy lại giỏ hàng hiện tại
        $cartItems = Cart::with('products')->where('user_id', Auth::id())->get();

        // Tính lại tổng giá trị giỏ hàng
        $subtotal = $cartItems->sum(function ($item) {
            return $item->products ? $item->products->price * $item->quantity : 0;
        });

        // Phí vận chuyển và thuế
        $shippingFee = 0;
        $taxes = 0;

        // Tính tổng tiền
        $totalPrice = $subtotal + $shippingFee + $taxes;

        return response()->json([
            'status' => 'success',
            'message' => 'Sản phẩm đã được xóa',
            'subtotal' => $subtotal,
            'totalPrice' => $totalPrice,
            'cartItems' => $cartItems
        ]);
    }

    public function getCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('products')->get();
        $messages = $this->checkCartStatus();

        // Trả về view giỏ hàng dưới dạng HTML
        return view('client.partials.cartright', compact('cartItems', 'messages'))->render();
    }

    public function checkCartStatus()
    {
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->get();
        $messages = []; // Lưu thông báo cho các sản phẩm bị xóa hoặc hết hàng

        foreach ($cartItems as $item) {
            $product = Product::withTrashed()->find($item->product_id); // Lấy cả sản phẩm bị xóa mềm

            if (!$product || $product->deleted_at || $product->quantity == 0 || $product->active == 0) {
                // Thêm thông báo vào mảng
                if ($product && $product->deleted_at) {
                    $messages[] = 'Sản phẩm ' . $item->product_name . ' đã bị xóa bởi nhà cung cấp.';
                } elseif ($product && $product->quantity == 0) {
                    $messages[] = 'Sản phẩm ' . $item->product_name . ' đã hết hàng.';
                } elseif ($product && $product->active == 0) {
                    $messages[] = 'Sản phẩm ' . $item->product_name . ' hiện không hoạt động.';
                } else {
                    $messages[] = 'Sản phẩm không tồn tại.';
                }

                // Xóa sản phẩm không hợp lệ khỏi giỏ hàng
                $item->delete();
            }
        }

        return $messages;
    }

    public function getCartQuantity()
    {
        if (!Auth::check()) {
            return response()->json(['total_quantity' => 0]);
        }

        $totalQuantity = Cart::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['total_quantity' => $totalQuantity]);
    }
}
