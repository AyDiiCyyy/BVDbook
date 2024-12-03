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
            @if (!empty($messages))
                @foreach ($messages as $message)
                    <div class="alert alert-warning">
                        {{ $message }}
                    </div>
                @endforeach
            @endif

            <div class="row" style="margin-top: -80px">
                <div class="col-lg-12">
                    <form action="#">
                        <div class="table-content table-responsive cart-table-content">
                            @if (isset($cartItems) && $cartItems->count() > 0)
                                <table>
                                    <thead>
                                        <tr>
                                            <th>#</th>
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
                                                    <a>{{ $loop->iteration }}</a>
                                                </td>
                                                <td class="product-thumbnail" style="width: 100px;">
                                                    <a href="#">
                                                        <img src="{{ asset($cartItem->products->image) }}"
                                                            alt="{{ $cartItem->products->name }}"
                                                            style="width: 120px; height: 160px; object-fit: cover; border-radius: 8px;" />
                                                    </a>
                                                </td>
                                                <td class="product-name" style="max-width: 200px; word-wrap: break-word;">
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
                                                    <a href="#" class="remove-item" data-id="{{ $cartItem->id }}"><i
                                                            class="fa fa-times"></i></a>
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
                                        <h4>Phí giao hàng : <span>{{ number_format($shippingFee, 0, '.', '.') }}₫</span>
                                        </h4>
                                        <h4 class="shop-total">Thành tiền :
                                            <span id="totalPrice">{{ number_format($totalPrice, 0, '.', '.') }}₫</span>
                                        </h4>
                                    </div>
                                </div>
                            @else
                                <div class="col-lg-12 text-center" style="margin-bottom: 70px">
                                    <h4>Giỏ hàng của bạn đang trống.</h4>
                                    <a href="{{ route('index') }}" class="btn btn-dark mt-3">Tiếp tục mua sắm</a>
                                </div>
                            @endif
                        </div>
                        @if (isset($cartItems) && $cartItems->count() > 0)
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="cart-shiping-update-wrapper">
                                        <div class="cart-shiping-update">
                                            <a href="{{ route('index') }}">Tiếp tục mua sắm</a>
                                        </div>
                                        <div class="cart-clear">
                                            <a href="{{ route('checkout') }}">Thanh toán</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart area end -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // Hàm định dạng số tiền
            function formatCurrency(number) {
                return new Intl.NumberFormat('vi-VN').format(number) + '₫';
            }
            // Lắng nghe sự kiện click trên các thẻ <a> với class .minus và .plus
            $('.minus, .plus').on('click', function(e) {
                e.preventDefault(); // Ngăn chặn hành động mặc định của thẻ

                var cartId = $(this).data('id'); // Lấy ID của sản phẩm trong giỏ hàng
                var quantityInput = $(this).siblings('.cart-quantity');
                var currentQuantity = parseInt(quantityInput.val()); // Lấy giá trị số lượng hiện tại
                var action = $(this).data('action');

                // Kiểm tra nếu là nút minus và số lượng hiện tại <= 1
                if (action === 'minus' && currentQuantity <= 1) {
                    return; // Không làm gì nếu số lượng <= 1
                }

                // Gửi AJAX request để cập nhật giỏ hàng
                $.ajax({
                    url: '/cart/update',
                    method: 'POST',
                    data: {
                        cart_item_id: cartId,
                        quantity: currentQuantity,
                        action: action,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    success: function(response) {

                        if (response.status === 'success') {
                            $(".cart-quantity-" + response.cart_id).val(response
                                .cart_item_quantity);
                            $('.product-subtotal-' + response.cart_id).text(formatCurrency(
                                response
                                .cart_item_price));
                            $('#subtotal').text(response.totalPrice);
                            $('#totalPrice').text(response.totalPrice);
                        } else {
                            Swal.fire({
                                title: "Thất bại!",
                                text: response.message, // Lấy thông báo lỗi từ server
                                icon: "error",
                                confirmButtonText: "OK",
                            });
                        }
                    }
                });
            });


            $('.remove-item').on('click', function(e) {
                e.preventDefault();

                var cartItemId = $(this).data('id');

                // Hiển thị SweetAlert để xác nhận xóa
                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
                    text: "Sản phẩm sẽ bị xóa khỏi giỏ hàng.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Hủy',
                    confirmButtonText: 'Xóa'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/cart/remove',
                            method: 'POST',
                            data: {
                                cart_item_id: cartItemId,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    // Xóa sản phẩm khỏi bảng
                                    $('tr').has('.remove-item[data-id="' + cartItemId +
                                        '"]').remove();

                                    // Cập nhật tổng tiền từ dữ liệu trả về
                                    $('#subtotal').text(formatCurrency(response
                                        .subtotal));
                                    $('#totalPrice').text(formatCurrency(response
                                        .totalPrice));

                                    Swal.fire({
                                        title: "Thành công!",
                                        text: "Xóa sản phẩm thành công",
                                        icon: "success",
                                        confirmButtonText: "OK",
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Thất bại!",
                                        text: response
                                            .message, // Lấy thông báo lỗi từ server
                                        icon: "error",
                                        confirmButtonText: "OK",
                                    });
                                }
                            }
                        });
                    }
                });
            });
            // Hàm định dạng tiền tệ
            function formatCurrency(amount) {
                return amount.toLocaleString('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                });
            }
            // Đóng modal khi hủy bỏ
            $('#cancelDeleteBtn').on('click', function() {
                $('#confirmDeleteModal').modal('hide');
            });
        });
    </script>
@endsection
