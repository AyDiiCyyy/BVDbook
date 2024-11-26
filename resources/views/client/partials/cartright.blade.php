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
                        <li>
                            <a href="#" class="image">
                                <img src="{{ asset($cartItem->products->image) }}" alt="Cart product Image">
                            </a>
                            <div class="content">
                                <p>Tên sản phẩm: </p>
                                <a href="{{ asset($cartItem->products->image) }}" class="title">
                                    {{ $cartItem->products->name }}
                                </a>
                                <span class="quantity-price">
                                    <p>Số lượng X Giá sản phẩm: </p>
                                    <br>
                                    {{ $cartItem->quantity }} x <span
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
