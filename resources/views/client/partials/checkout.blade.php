<style>
    .voucher-list {
        max-height: 300px;
        /* Giới hạn chiều cao */
        overflow-y: auto;
        /* Hiển thị thanh cuộn */
        border: 1px solid #e7e7e7;
        padding: 10px;
        border-radius: 5px;
    }

    /* Thanh cuộn */
    .voucher-list::-webkit-scrollbar {
        width: 10px;
        /* Độ rộng của thanh cuộn */
    }

    /* Đổi màu thanh trượt */
    .voucher-list::-webkit-scrollbar-thumb {
        background: linear-gradient(45deg, #ff6b6b, #ffcc00);
        /* Màu gradient */
        border-radius: 5px;
        /* Góc bo tròn */
    }

    /* Đổi màu khi di chuột qua thanh trượt */
    .voucher-list::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(45deg, #ff4757, #ffa502);
        /* Màu gradient đậm hơn */
    }

    /* Nền của thanh trượt */
    .voucher-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Màu nền nhạt */
        border-radius: 5px;
    }

    /* Đổi màu nền khi hover lên track */
    .voucher-list::-webkit-scrollbar-track:hover {
        background: #e2e2e2;
        /* Màu nền đậm hơn khi hover */
    }

    .form-check {
        position: relative;
        padding: 10px 15px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: all 0.3s ease;
        background-color: #fff;
        cursor: pointer;
        /* Biến toàn bộ form-check thành vùng có thể click */
    }

    .form-check:hover {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
    }

    .form-check-input {
        position: absolute;
        opacity: 0;
        /* Ẩn input */
        pointer-events: none;
        /* Không cho click trực tiếp */
    }

    .form-check-label {
        margin: 0;
        padding: 0;
        font-size: 16px;
        font-weight: 500;
        color: #333;
        display: flex;
        align-items: center;
    }

    .form-check-label::before {
        content: "";
        width: 20px;
        height: 20px;
        border: 2px solid #ddd;
        border-radius: 50%;
        margin-right: 15px;
        background-color: #fff;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .form-check:hover .form-check-label::before {
        border-color: #007bff;
    }

    .form-check-input:checked+.form-check-label::before {
        content: "✓";
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 14px;
    }
</style>
<!-- checkout area start -->
<div class="checkout-area mt-60px mb-40px">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="billing-info-wrap">
                    <h3>Thông tin giao hàng</h3>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="billing-info mb-20px">
                                <label>Họ và Tên</label>
                                <input id="name_ajax" type="text" placeholder="Nhập tên nhận hàng" name="name"
                                    value="{{ $user->name }}" />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="billing-info mb-20px">
                                <label>Số điện thoại</label>
                                <input id="phone_ajax" type="text" placeholder="Nhập số điện thoại nhận hàng"
                                    name="phone" value="{{ $user->phone }}" />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="billing-info mb-20px">
                                <label>Địa chỉ nhận hàng</label>
                                <input id="address_ajax" type="text" placeholder="Nhập địa chỉ nhận hàng của bạn"
                                    name="address" value="{{ $user->address }}" />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="billing-info mb-20px">
                                <label>Email</label>
                                <input id="email_ajax" type="email" placeholder="Nhập email nếu có" name="email"
                                    value="{{ $user->email }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="discount-code-wrapper">
                            <div class="title-wrap">
                                <h4 class="cart-bottom-title section-bg-gray">Sử dụng mã giảm giá</h4>
                            </div>
                            <div class="discount-code">
                                <p>Nhập mã mã giảm giá nếu bạn có</p>
                                <form>
                                    <input type="text" name="sku" id="input_voucher_ajax">
                                    <button class="cart-btn-2" id="btn_voucher_ajax" type="button">Áp dụng mã giảm
                                        giá</button>
                                </form>
                                <div class="col-lg-12 col-md-12">
                                    <div class="voucher-wrapper mt-4">
                                        <div class="title-wrap">
                                            <h4 class="cart-bottom-title section-bg-gray mb-3">Danh sách Voucher trong
                                                ví</h4>
                                        </div>
                                        <div class="voucher-list" style="max-height: 300px; overflow-y: auto;">
                                            @foreach ($vouchers as $voucher)
                                                <div class="card mb-3">
                                                    <div
                                                        class="card-body d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h5 class="card-title mb-1">{{ $voucher->name }}</h5>
                                                            <p class="card-text text-muted">Cho đơn hàng từ
                                                                {{ number_format($voucher->min_order_amount, 0, '.', '.') }}
                                                                VND, áp
                                                                dụng đến {{ date('d/m/Y', strtotime($voucher->end)) }}
                                                            </p>
                                                        </div>
                                                        <button
                                                            class="btn btn-primary btn-sm apply-voucher apply_voucher_ajax"
                                                            data-id="{{ $voucher->id }}">Sử dụng</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-lg-5">
                <div class="your-order-area">
                    <h3>Đơn hàng của bạn</h3>
                    <div class="your-order-wrap gray-bg-4">
                        <div class="your-order-product-info">
                            <div class="your-order-top">
                                <ul>
                                    <li>Sản phẩm</li>
                                    <li>Giá tiền</li>
                                </ul>
                            </div>
                            <div class="your-order-middle">
                                <ul>
                                    @foreach ($products as $product)
                                        <li><span class="order-middle-left">{{ $product->products->name }} X
                                                {{ $product->quantity }}</span> <span
                                                class="order-price">{{ number_format($product->products->price * $product->quantity, 0, '.', '.') }}₫
                                            </span></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="your-order-bottom mb-2">
                                <ul>
                                    <li class="your-order-shipping">Vận chuyển</li>
                                    <li>Miễn phí vận chuyển</li>
                                </ul>
                            </div>
                            <div class="your-order-bottom">
                                <ul>
                                    <li class="your-order-shipping">Mã giảm giá</li>
                                    <li id="voucher_ajax">- 0 ₫</li>
                                </ul>
                            </div>
                            <div class="your-order-total">
                                <ul>
                                    <li class="order-total">Tổng tiền</li>
                                    <li id="sum_ajax">{{ number_format($sum, 0, '.', '.') }}₫</li>
                                </ul>
                            </div>
                        </div>
                        <div class="payment-method">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="0" name="payment"
                                    id="method-cod" checked>
                                <label class="form-check-label" for="method-cod">
                                    Thanh toán khi nhận hàng
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="1" name="payment"
                                    id="method-vnpay">
                                <label class="form-check-label" for="method-vnpay">
                                    Thanh toán VNPay
                                </label>
                            </div>
                        </div>


                    </div>
                    <div class="Place-order mt-25" id="pay_ajax">
                        <a class="btn-hover">Đặt hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- checkout area end -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        function checkVoucher() {
            var voucher = $('#input_voucher_ajax').val();
            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                url: '{{ route('checkvoucher') }}',
                type: "POST",
                data: {
                    sku: voucher,
                    sum: {{ $sum }},
                    _token: csrfToken,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        var voucher = $('#voucher_ajax').text(parseFloat(response.voucher
                            .discount_amount).toLocaleString('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }));
                        var sum = $('#sum_ajax').text(parseFloat(response.sum - response.voucher
                            .discount_amount).toLocaleString('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }));
                        Swal.fire({
                            title: "Thành công!",
                            text: "Áp dụng mã giảm giá thành công!",
                            icon: "success",
                            confirmButtonText: "OK",
                        });
                    } else if (response.status == 'warning') {
                        Swal.fire({
                            title: response.message,
                            text: "Vui lòng cập nhật lại giỏ hàng!",
                            icon: "warning",
                            confirmButtonText: "OK",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Tải lại trang sau khi xác nhận
                            }
                        });
                    } else {

                        Swal.fire({
                            title: "Sử dụng Voucher thất bại!",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Status: " + status);
                    console.error("Error: " + error);
                    console.error("Response Text: " + xhr.responseText);
                },
            });

        }

        function useVoucher(button) {
            var id = button.data("id");
            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                url: '{{ route('usevoucher') }}',
                type: "POST",
                data: {
                    id: id,
                    sum: {{ $sum }},
                    _token: csrfToken,
                },
                success: function(response) {
                    if (response.status == 'success') {
                        var voucher = $('#voucher_ajax').text(parseFloat(response.voucher
                            .discount_amount).toLocaleString('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }));
                        var sum = $('#sum_ajax').text(parseFloat(response.sum - response.voucher
                            .discount_amount).toLocaleString('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }));
                        Swal.fire({
                            title: "Thành công!",
                            text: "Áp dụng mã giảm giá thành công!",
                            icon: "success",
                            confirmButtonText: "OK",
                        });
                    } else if (response.status == 'warning') {
                        Swal.fire({
                            title: response.message,
                            text: "Vui lòng cập nhật lại giỏ hàng!",
                            icon: "warning",
                            confirmButtonText: "OK",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Tải lại trang sau khi xác nhận
                            }
                        });
                    } else {

                        Swal.fire({
                            title: "Sử dụng Voucher thất bại!",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Status: " + status);
                    console.error("Error: " + error);
                    console.error("Response Text: " + xhr.responseText);
                },

            });
        }

        function pay() {
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            var name = $('#name_ajax').val();
            var phone = $('#phone_ajax').val();
            var address = $('#address_ajax').val();
            var email = $('#email_ajax').val();
            var selectedPayment = $('input[name="payment"]:checked').val();
            // if (selectedPayment == 0) {
            //     console.log('Thanh toán khi nhận hàng được chọn.');
            // } else if (selectedPayment == 1) {
            //     console.log('Thanh toán VNPay được chọn.');
            // } else {
            //     console.log('Chưa có phương thức thanh toán nào được chọn.');
            // }
            $.ajax({
                url: '{{ route('pay') }}',
                type: "POST",
                data: {
                    name: name,
                    phone: phone,
                    address: address,
                    email: email,
                    payment: selectedPayment,
                    sum: {{ $sum }},
                    redirect: 'có cái nịt',
                    _token: csrfToken,
                },
                success: function(response) {
                    console.log(response);
                    
                    if (response.status == 'success') {
                        Swal.fire({
                            title: "Đặt hàng thành công!",
                            text: "Đơn hàng của bạn đang được xử lý! Vui lòng kiểm tra email để xem thông tin chi tiết",
                            icon: "success",
                            confirmButtonText: "OK",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Tải lại trang sau khi xác nhận
                            }
                        });
                    } else if (response.status == 'url') {
                        // console.log(response.url);
                        
                        window.location.href = response.url;
                    }else {
                        Swal.fire({
                            title: "Đặt hàng thất bại!",
                            text: 'Đã có lỗi trong quá trình đặt hàng',
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Status: " + status);
                    console.error("Error: " + error);
                    console.error("Response Text: " + xhr.responseText);
                },

            });
        }
        $("#btn_voucher_ajax").click(function() {
            checkVoucher();
        });
        $('.apply_voucher_ajax').click(function() {
            useVoucher($(this));
        })
        $("#pay_ajax").click(function() {
            pay();
        });
    });
</script>
