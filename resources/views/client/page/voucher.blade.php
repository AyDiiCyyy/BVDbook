@extends('client.layouts')

@section('title', 'Danh Sách Đơn Hàng')

@section('content')
<style>
/* Tổng thể */
.voucher-list {
    margin-top: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Tăng khoảng cách giữa các voucher */
}

/* Mỗi voucher */
.voucher-item {
    flex: 1 1 calc(50% - 20px); /* Hiển thị 2 voucher mỗi hàng */
    min-width: 280px; /* Tăng kích thước tối thiểu của voucher */
    min-height: 180px; /* Tăng chiều cao của voucher */
    background: linear-gradient(135deg, #f0f8ff, #e6f7ff);
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    padding: 25px; /* Tăng padding cho voucher */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: flex-start;
    transition: transform 0.3s, box-shadow 0.3s;
}

/* Hiệu ứng hover */
.voucher-item:hover {
    transform: translateY(-8px);
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
    border: 1px solid #007bff;
}

/* Nội dung voucher */
.voucher-content {
    width: 100%;
    font-size: 1rem; /* Cải thiện kích thước font */
    line-height: 1.5;
}

/* Các thông tin */
.voucher-discount {
    font-size: 1.2rem; /* Tăng kích thước font cho phần giảm giá */
    font-weight: bold;
    color: #28a745;
}

.voucher-minimum {
    font-size: 1rem; /* Tăng kích thước font */
    color: #555;
}

.voucher-minimum .text-primary {
    font-weight: bold;
    color: #007bff;
}

.voucher-expiry {
    font-size: 0.95rem; /* Điều chỉnh kích thước cho ngày hết hạn */
    color: #666;
}

.voucher-expiry .text-warning {
    font-weight: bold;
    color: #d9534f;
}

/* Nút lưu */
.btn-save {
    align-self: flex-end;
    padding: 10px 20px; /* Tăng kích thước nút */
    border-radius: 20px;
    font-size: 1rem;
    color: #fff;
    background-color: #28a745;
    border: none;
    transition: background-color 0.3s, transform 0.3s;
}

.btn-save:hover {
    background-color: #218838;
    transform: scale(1.05);
}

/* Media Queries */
@media screen and (max-width: 768px) {
    .voucher-item {
        flex: 1 1 calc(50% - 20px); /* Đảm bảo 2 voucher mỗi hàng trên màn hình vừa */
    }
}

@media screen and (max-width: 480px) {
    .voucher-item {
        flex: 1 1 100%; /* Chế độ 1 voucher mỗi hàng trên màn hình nhỏ */
    }
    .voucher-content {
        font-size: 0.95rem; /* Giảm kích thước font cho màn hình nhỏ */
    }
}

/* Thanh điều hướng */
.voucher-nav .nav-tabs {
    border-bottom: 2px solid #e0e0e0;
}

.voucher-nav .nav-link {
    color: #555;
    padding: 10px 15px;
    border: 1px solid transparent;
    border-radius: 5px 5px 0 0;
    background-color: #f9f9f9;
    transition: background-color 0.3s, color 0.3s;
}

.voucher-nav .nav-link.active {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff #007bff #fff;
    font-weight: bold;
}

.voucher-nav .nav-link:hover {
    color: #007bff;
    background-color: #e9ecef;
}


</style>
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-heading">Kho voucher</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="{{ route('index') }}">Trang Chủ</a></li>
                            <li>Kho voucher</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="account-area mtb-60px">
        <div class="container">
            <div class="row">
                @include('client.partials.nav_right_order')
                <!-- Danh Sách Đơn Hàng -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <!-- Thanh điều hướng -->
                            <nav class="voucher-nav mb-4">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('voucher') ? 'active' : '' }}" href="{{ route('voucher') }}">Tất cả voucher</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('myvoucher') ? 'active' : '' }}" href="{{ route('myvoucher') }}">Kho voucher của bạn</a>
                                    </li>
                                </ul>
                            </nav>
                    
                            <!-- Form nhập mã voucher -->
                            <form method="POST" action="/save-voucher">
                                @csrf <!-- Laravel bảo vệ CSRF -->
                                <div class="form-group">
                                    <label for="voucher" class="form-label">Nhập mã Voucher</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="input_voucher_ajax" placeholder="Nhập mã voucher tại đây">
                                        <button type="button" id="btn_voucher_ajax" class="btn btn-primary">Lưu</button>
                                    </div>
                                </div>
                            </form>
                    
                            <!-- Danh sách voucher -->
                            <div class="voucher-list mt-4">
                                @foreach ($voucher as $item)
                                <div class="voucher-item">
                                    <div class="voucher-content">
                                        <p class="voucher-discount">Giảm: <span class="text-success">{{ number_format($item->discount_amount, 0, '.', '.') }} ₫</span></p>
                                        <p class="voucher-minimum">Áp dụng cho đơn từ: <span class="text-primary">{{ number_format($item->min_order_amount, 0, '.', '.') }} ₫</span></p>
                                        <p class="voucher-expiry">Hạn sử dụng: <span class="text-warning">{{ date('d/m/Y', strtotime($item->end)) }}</span></p>
                                    </div>
                                    <button class="btn btn-success btn-save apply_voucher_ajax" data-id="{{ $item->id }}">Lưu</button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {    
            function save_input() {
                var voucher = $('#input_voucher_ajax').val();
                var csrfToken = $('meta[name="csrf-token"]').attr("content");

                $.ajax({
                    url: '{{ route('save_input') }}',
                    type: "POST",
                    data: {
                        sku: voucher,
                        _token: csrfToken,
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: "Thành công!",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: "OK",
                            }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Tải lại trang sau khi xác nhận
                            }
                        });
                        } else if (response.status == 'warning') {
                            Swal.fire({
                                title: 'Cảnh báo!',
                                text: response.message,
                                icon: "warning",
                                confirmButtonText: "OK",
                            })
                        }else {
    
                            Swal.fire({
                                title: "Lưu Voucher thất bại!",
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
                    url: '{{ route('save') }}',
                    type: "POST",
                    data: {
                        id: id,
                        _token: csrfToken,
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: "Thành công!",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: "OK",
                            }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Tải lại trang sau khi xác nhận
                            }
                        });
                        } else if (response.status == 'warning') {
                            Swal.fire({
                                title: 'Cảnh báo!',
                                text: response.message,
                                icon: "warning",
                                confirmButtonText: "OK",
                            })
                        }else {
    
                            Swal.fire({
                                title: "Lưu Voucher thất bại!",
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
    
            $("#btn_voucher_ajax").click(function() {
                save_input();
            });
            $('.apply_voucher_ajax').click(function() {
                useVoucher($(this));
            })
        });
    </script>
@endsection
