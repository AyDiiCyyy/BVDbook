<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
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

        // Lấy giá sản phẩm, nếu có giá sale thì dùng giá sale
        $price = $product->sale > 0 ? $product->sale : $product->price;

        if ($cartItem) {
            // Nếu có rồi, cộng thêm số lượng
            $total_cart_item = $cartItem->quantity + $validated['quantity'];

            // Kiểm tra tổng số lượng không vượt quá số lượng trong kho
            if ($total_cart_item > $product->quantity) {
                return response()->json(['status' => 'error', 'message' => 'Số lượng sản phẩm vượt quá số lượng tồn kho'], 400);
            }

            $cartItem->update([
                'quantity' => $total_cart_item,
                'total_price' => $total_cart_item * $price,
            ]);
        } else {
            if ($validated['quantity'] > $product->quantity) {
                return response()->json(['status' => 'error', 'message' => 'Số lượng sản phẩm vượt quá số lượng tồn kho'], 400);
            }

            // Nếu chưa có, tạo mới giỏ hàng
            $cartItem = Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'total_price' => $price * $validated['quantity'],
            ]);
        }

        // Tính tổng số lượng và tổng giá trị của giỏ hàng
        $totalQuantity = Cart::where('user_id', $user->id)->sum('quantity');
        $totalPrice = Cart::where('user_id', $user->id)->sum('total_price');

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


        //Tính tổng giá trị giỏ hàng
        $subtotal = $cartItems->sum('total_price');

        //Tính phí vận chuyển
        $shippingFee = 0;

        //Tính tổng giá trị
        $totalPrice = $subtotal + $shippingFee;
        $totalQuantity = $cartItems->count();


        //dd($cartItems, $subtotal, $totalPrice);

        // Truyền dữ liệu vào view
        return view('client.partials.cart', compact('cartItems', 'subtotal', 'totalPrice', 'totalQuantity', 'shippingFee', 'messages',));
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

        // Lấy giá sản phẩm, nếu có giá sale thì dùng giá sale
        $price = $product->sale > 0 ? $product->sale : $product->price;

        // Cập nhật số lượng sản phẩm
        if ($action == "plus") {
            $cart_item_quantity = $quantity + 1;
        } else {
            $cart_item_quantity = $quantity - 1;
        }

        // Kiểm tra số lượng tồn kho
        if ($cart_item_quantity > $product->quantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Số lượng sản phẩm vượt quá số lượng tồn kho.'
            ]);
        }

        $cart_item_price = $price * $cart_item_quantity;

        $cartItem->quantity = $cart_item_quantity;
        $cartItem->total_price = $cart_item_price;
        $cartItem->save();

        $total_price = Cart::query()->where('status', 0)->where('user_id', Auth::id())->sum('total_price');

        // Cập nhật phí vận chuyển
        $shippingFee = 0;

        // Tính tổng giá trị giỏ hàng
        $totalPrice = $total_price + $shippingFee;
        $totalQuantity = Cart::where('user_id', Auth::id())->distinct('product_id')->count();

        return response()->json([
            'status' => 'success',
            'cart_id' => $cart_id,
            'cart_item_quantity' => $cart_item_quantity,
            'cart_item_price' => $cart_item_price,
            'totalPrice' => number_format($totalPrice, 0, '.', '.'),
            'totalQuantity' => $totalQuantity
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
        $subtotal = $cartItems->sum('total_price');

        // Phí vận chuyển và thuế
        $shippingFee = 0;

        // Tính tổng tiền
        $totalPrice = $subtotal + $shippingFee;
        $totalQuantity = $cartItems->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Sản phẩm đã được xóa',
            'subtotal' => $subtotal,
            'totalPrice' => $totalPrice,
            'cartItems' => $cartItems,
            'totalQuantity' => $totalQuantity

        ]);
    }

    public function getCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('products')->get();
        $totalQuantity = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity; // Lấy số lượng của từng sản phẩm trong giỏ hàng
        });
        $messages = $this->checkCartStatus();
        $cart_html = view('client.partials.cartright', compact('cartItems',  'messages'))->render();
        // Trả về view giỏ hàng dưới dạng HTML
        return response()->json([
            'cart_html' => $cart_html,
            'total_quantity' => $totalQuantity,
        ]);
    }

    public function checkCartStatus()
    {
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->get();
        $messages = []; // Lưu thông báo cho các sản phẩm bị xóa hoặc hết hàng

        foreach ($cartItems as $item) {
            $product = Product::withTrashed()->find($item->product_id); // Lấy cả sản phẩm bị xóa mềm

            if (!$product || $product->deleted_at) {
                $messages[] = [
                    'product_id' => $item->product_id,
                    'message' => 'Sản phẩm này đã bị xóa.'
                ];
            } elseif ($product->quantity == 0) {
                $messages[] = [
                    'product_id' => $item->product_id,
                    'message' => 'Sản phẩm này hiện đã hết hàng.'
                ];
            }
        }

        return $messages;
    }
}
