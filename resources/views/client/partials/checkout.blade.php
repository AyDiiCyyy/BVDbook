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

    #loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        /* Màn hình mờ */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 99999;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        /* Màu nền */
        border-top: 5px solid #3498db;
        /* Màu hiệu ứng */
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<div id="loading" style="display: none;">
    <div class="spinner"></div>
</div>

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
                                <div class="error-message text-danger" id="error-name"></div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="billing-info mb-20px">
                                <label>Số điện thoại</label>
                                <input id="phone_ajax" type="text" placeholder="Nhập số điện thoại nhận hàng"
                                    name="phone" value="{{ $user->phone }}" />
                                <div class="error-message text-danger" id="error-phone"></div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="billing-info mb-20px">
                                <label>Địa chỉ nhận hàng</label>
                                <input id="address_ajax" type="text" placeholder="Nhập địa chỉ nhận hàng của bạn"
                                    name="address" value="{{ $user->address }}" />
                                <div class="error-message text-danger" id="error-address"></div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="billing-info mb-20px">
                                <label>Email</label>
                                <input id="email_ajax" type="email" placeholder="Nhập email nếu có" name="email"
                                    value="{{ $user->email }}" />
                                <div class="error-message text-danger" id="error-email"></div>
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
                                                            <p class="card-text text-muted mt-3">Giảm:  {{ number_format($voucher->discount_amount, 0, '.', '.') }} VND
                                                            </p>
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

        function validateFields() {
            var isValid = true;

            // Xóa lỗi cũ
            $(".error-message").text("");

            // Kiểm tra Họ và Tên
            var name = $("#name_ajax").val().trim();
            if (name === "") {
                $("#error-name").text("Họ và Tên không được để trống.");
                isValid = false;
            } else if (name.length < 3) {
                $("#error-name").text("Họ và Tên phải có ít nhất 3 ký tự.");
                isValid = false;
            }

            // Kiểm tra Số điện thoại
            var phone = $("#phone_ajax").val().trim();
            var phoneRegex = /^[0-9]{10,11}$/; // Số điện thoại chỉ gồm 10-11 chữ số
            if (phone === "") {
                $("#error-phone").text("Số điện thoại không được để trống.");
                isValid = false;
            } else if (!phoneRegex.test(phone)) {
                $("#error-phone").text("Số điện thoại không hợp lệ.");
                isValid = false;
            }

            // Kiểm tra Địa chỉ
            var address = $("#address_ajax").val().trim();
            if (address === "") {
                $("#error-address").text("Địa chỉ không được để trống.");
                isValid = false;
            } else if (address.length < 5) {
                $("#error-address").text("Địa chỉ phải có ít nhất 5 ký tự.");
                isValid = false;
            }

            // Kiểm tra Email
            var email = $("#email_ajax").val().trim();
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Định dạng email cơ bản
            if (email !== "" && !emailRegex.test(email)) {
                $("#error-email").text("Email không hợp lệ.");
                isValid = false;
            }

            return isValid;
        }

        function showLoading() {
            document.getElementById("loading").style.display = "flex";
            document.body.style.overflow = "hidden"; // Chặn cuộn chuột
        }

        // Ẩn hiệu ứng loading
        function hideLoading() {
            document.getElementById("loading").style.display = "none";
            document.body.style.overflow = ""; // Mở lại cuộn chuột
        }

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
                    } else if (response.status == 'voucher da su dung') {
                        Swal.fire({
                            title: 'Voucher đã được áp dụng',
                            text: "Vui lòng chọn voucher khác nếu muốn đổi!",
                            icon: "warning",
                            confirmButtonText: "OK",
                        })
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
                    } else if (response.status == 'voucher da su dung') {
                        Swal.fire({
                            title: 'Voucher đã được áp dụng',
                            text: "Vui lòng chọn voucher khác nếu muốn đổi!",
                            icon: "warning",
                            confirmButtonText: "OK",
                        })
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

            if(validateFields()){
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
                    beforeSend: function() {
                        showLoading(); // Hiển thị hiệu ứng trước khi gửi request
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: "Đặt hàng thành công!",
                                text: "Đơn hàng của bạn đang được xử lý! Vui lòng kiểm tra email để xem thông tin chi tiết",
                                icon: "success",
                                confirmButtonText: "OK",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('client.account.orders') }}';
                                }
                            });
                        } else if (response.status == 'url') {
                            // console.log(response.url);
    
                            window.location.href = response.url;
                        } else {
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
                    complete: function() {
                        hideLoading(); // Ẩn hiệu ứng sau khi xử lý xong
                    }
    
                });
            }

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
        $("#name_ajax, #phone_ajax, #address_ajax, #email_ajax").on("input", function () {
        validateFields();
    });
    });
</script>
