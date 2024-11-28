<div class="inner" id="cart-right">
    <div class="head">
        <span class="title">Giỏ hàng</span>
        <button class="offcanvas-close">×</button>
    </div>
    <div class="body customScroll">
        <ul class="minicart-product-list">
            @if (isset($cartItems) && $cartItems->count() > 0)
                @foreach ($cartItems as $cartItem)
                    @if ($cartItem->products)
                        <!-- Kiểm tra xem product có tồn tại không -->
                        <li style="display: flex; align-items: center; margin-bottom: 15px;">
                            <a href="#" class="image" style="flex-shrink: 0;">
                                <img src="{{ asset($cartItem->products->image) }}" alt="Cart product Image"
                                    style="width: 120px; height: 150px; object-fit: cover; border-radius: 8px;">
                            </a>
                            <div class="content" style="flex: 1; padding-left: 10px;">
                                <p style="margin: 0; font-size: 14px; word-wrap: break-word; max-width: 200px;">Tên sản
                                    phẩm: {{ $cartItem->products->name }}</p>
                                <span class="quantity-price">
                                    <p style="margin: 5px 0 0;">Số lượng: {{ $cartItem->quantity }}</p>
                                    Giá sản phẩm: <span
                                        class="amount">{{ number_format($cartItem->products->price, 0, '.', '.') }}₫</span>
                                </span>
                            </div>
                        </li>
                    @else
                        <li>
                            <p>Sản phẩm không tồn tại.</p>
                        </li>
                    @endif
                @endforeach
            @else
                <p>Giỏ hàng của bạn đang trống.</p>
            @endif
        </ul>
    </div>
    <div class="shopping-cart-total">
        @if (isset($subtotal))
            <h4>Tổng tiền : <span>{{ number_format($subtotal, 0, '.', '.') }}₫</span></h4>
        @endif
        @if (isset($shippingFee))
            <h4>Phí giao hàng : <span>{{ number_format($shippingFee, 0, '.', '.') }}₫</span></h4>
        @endif
        @if (isset($subtotal))
            <h4 class="shop-total">Thành tiền : <span>{{ number_format($totalPrice, 0, '.', '.') }}₫</span></h4>
        @endif
    </div>
    <div class="foot">
        <div class="buttons">
            <a href="{{ route('cart.show') }}" class="btn btn-dark btn-hover-primary mb-30px">Xem giỏ hàng</a>
            <a href="#" class="btn btn-outline-dark current-btn">Thanh toán</a>
        </div>
    </div>
</div>
