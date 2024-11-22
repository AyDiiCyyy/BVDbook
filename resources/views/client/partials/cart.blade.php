@extends('client.layouts')

@section('title')
    Giỏ Hàng
@endsection

@section('content')
    <!-- Breadcrumb Area start -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-hrading">Trang giỏ hàng</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="{{ route('index') }}">Trang chủ</a></li>
                            <li>Giỏ hàng</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Area End -->

    <!-- Cart area start -->
    <div class="cart-main-area mtb-60px">
        <div class="container">
            <h3 class="cart-page-title">Giỏ hàng của tôi</h3>
            <div class="row">
                <div class="col-lg-12">
                    <form action="#">
                        <div class="table-content table-responsive cart-table-content">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                        <th>Tùy chỉnh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $cartItem)
                                        <tr>
                                            <td class="product-id">
                                                <a href="#">{{ $cartItem->products->id }}</a>
                                            </td>
                                            <td class="product-thumbnail">
                                                <a href="#">
                                                    <img src="{{ asset($cartItem->products->image) }}"
                                                        alt="{{ $cartItem->products->name }}" />
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a href="#">{{ $cartItem->products->name }}</a>
                                            </td>
                                            <td class="product-price-cart">
                                                <span
                                                    class="amount">{{ number_format($cartItem->products->price, 0, '.', '.') }}₫</span>
                                            </td>
                                            <td class="product-quantity">
                                                <div class="input-group quantity-wrapper" style="width: 120px;">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm minus"
                                                        data-id="{{ $cartItem->id }}" data-action="minus">−</a>
                                                    <input type="text"
                                                        class="form-control text-center cart-quantity cart-quantity-{{ $cartItem->id }}"
                                                        data-id="{{ $cartItem->id }}" value="{{ $cartItem->quantity }}"
                                                        min="1">
                                                    <a href="#" class="btn btn-outline-secondary btn-sm plus"
                                                        data-id="{{ $cartItem->id }}" data-action="plus">+</a>
                                                </div>
                                            </td>
                                            <td class="product-subtotal-{{ $cartItem->id }}"
                                                data-id="{{ $cartItem->id }}">
                                                {{ number_format($cartItem->products->price * $cartItem->quantity, 0, '.', '.') }}₫
                                            </td>
                                            <td class="product-remove">
                                                <a href="#"><i class="fa fa-pencil-alt"></i></a>
                                                <a href="#"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col-lg-12 d-flex justify-content-end ">
                                <div class="shopping-cart-total me-5">
                                    <!-- Thông tin tổng tiền -->
                                    <h4>Tổng tiền : <span
                                            id="subtotal">{{ number_format($subtotal, 0, '.', '.') }}₫</span></h4>
                                    <h4>Phí giao hàng : <span>{{ number_format($shippingFee, 0, '.', '.') }}₫</span></h4>
                                    <h4>Thuế : <span>{{ number_format($taxes, 0, '.', '.') }}₫</span></h4>
                                    <h4 class="shop-total">Thành tiền :
                                        <span id="totalPrice">{{ number_format($totalPrice, 0, '.', '.') }}₫</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-shiping-update-wrapper">
                                    <div class="cart-shiping-update">
                                        <a href="{{ route('index') }}">Continue Shopping</a>
                                    </div>
                                    <div class="cart-clear">
                                        <button type="submit">Update Shopping Cart</button>
                                        <a href="#">Clear Shopping Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart area end -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Lắng nghe sự kiện click trên các thẻ <a> với class .minus và .plus
            $('.minus, .plus').on('click', function(e) {
                e.preventDefault(); // Ngăn chặn hành động mặc định của thẻ <a> (chuyển trang)

                var cartId = $(this).data('id'); // Lấy ID của sản phẩm trong giỏ hàng
                var quantityInput = $(this).parent().children('.cart-quantity')
                    .val(); // Tìm thẻ <input> chứa số lượng

                var action = $(this).data('action');

                // Gửi AJAX request để cập nhật giỏ hàng
                $.ajax({
                    url: '/cart/update', // Đường dẫn tới phương thức update
                    method: 'POST',
                    data: {
                        cart_item_id: cartId,
                        quantity: quantityInput,
                        action: action,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    success: function(response) {
                        console.log(cartId);
                        console.log(123);

                        if (response.status === 'success') {
                            $(".cart-quantity-" + response.cart_id).val(response
                                .cart_item_quantity);
                            $('product-subtotal-' + response.cart_id).text(response
                                .cart_item_price);
                            $('#subtotal').text(response.totalPrice);
                            $('#totalPrice').text(response.totalPrice);
                        } else {
                            alert(response.message); // Thông báo lỗi nếu có
                        }
                    }
                });
            });
        });
    </script>
@endsection
