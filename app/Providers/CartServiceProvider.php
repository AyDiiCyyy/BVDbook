<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Kiểm tra người dùng đã đăng nhập chưa
            if (Auth::check()) {
                $user = Auth::user();

                // Lấy sản phẩm trong giỏ hàng
                $cartItems = Cart::with('products')->where('user_id', $user->id)->get();

                $totalQuantity = Cart::where('user_id', $user->id)->sum('quantity'); // Tính tổng số lượng trong giỏ hàng

                // Tính tổng giá trị giỏ hàng
                $subtotal = $cartItems->sum(function ($cartItem) {
                    return $cartItem->products ? $cartItem->products->price * $cartItem->quantity : 0;
                });

                // Phí vận chuyển và thuế
                $shippingFee = 0;
                $taxes = 0;
                $totalPrice = $subtotal + $shippingFee + $taxes;

                // Chia sẻ dữ liệu với tất cả các view
                $view->with([
                    'cartItems' => $cartItems,
                    'subtotal' => $subtotal,
                    'shippingFee' => $shippingFee,
                    'taxes' => $taxes,
                    'totalPrice' => $totalPrice,
                    'totalQuantity' => $totalQuantity,
                ]);
            }
        });
    }
}
