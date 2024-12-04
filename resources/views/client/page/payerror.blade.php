@extends('client.layouts')

@section('title')
    Thanh toán thất bại
@endsection

@section('content')
    <audio autoplay loop id="audioPlayer">
        <source src="{{ asset('music/2.mp3') }}" type="audio/mpeg">
        Trình duyệt của bạn không hỗ trợ thẻ audio.
    </audio>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $("body").click(function() {
            var audioPlayer = document.getElementById('audioPlayer');
            setTimeout(function() {
                audioPlayer.play(); // Phát nhạc sau khi độ trễ
            }, 1000); // 2000ms = 2 giây
        });
    </script>
    <style>
        /* Đặt nền sáng và padding hợp lý, chiếm full màn hình */
        .thank-you-page {
            background-color: #f8f9fa;
            padding-top: 0;
            padding-bottom: 0;
            height: 88vh;
            /* Full màn hình */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Card đẹp hơn với shadow nhẹ và bo góc */
        .card {
            max-width: 100%;
            width: 100%;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Tiêu đề đẹp, căn giữa, màu sắc dễ nhìn */
        .display-4 {
            font-size: 3rem;
            font-weight: 700;
            color: #dc3545;
            /* Màu đỏ cho thông báo thất bại */
            margin-bottom: 20px;
        }

        /* Cải thiện text và các phần tử khác */
        .lead {
            font-size: 1.25rem;
            color: #6c757d;
            margin-bottom: 20px;
        }

        /* Icon thất bại với màu sắc và size lớn */
        .fa-times-circle {
            color: #dc3545;
            /* Màu đỏ cho thất bại */
            font-size: 80px;
            margin-bottom: 20px;
        }

        /* Thông tin đơn hàng */
        .order-info {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .order-info h4 {
            color: #343a40;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .order-info ul {
            list-style: none;
            padding: 0;
        }

        .order-info ul li {
            margin-bottom: 10px;
            font-size: 1rem;
            color: #495057;
        }

        /* Các nút bấm đẹp và dễ nhìn */
        .btn-lg {
            font-size: 1.1rem;
            padding: 15px 30px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #ffffff;
        }

        /* Thêm hiệu ứng fade cho các nút */
        .btn {
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
        }
    </style>

    <section class="breadcrumb-area" style="padding: 50px 0 30px 0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-hrading">Thanh toán thất bại</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="index.html">Trang Chủ</a></li>
                            <li>Thanh toán thất bại</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <!-- Card -->
        <div class="card shadow-lg">
            <div class="card-body text-center">
                <!-- Tiêu đề -->
                <h1 class="display-4">Rất tiếc!</h1>
                <p class="lead">Thanh toán của bạn không thành công. Vui lòng thử lại.</p>

                <!-- Icon thất bại -->
                <div class="my-4">
                    <i class="fas fa-times-circle"></i>
                </div>

                <!-- Thông tin đơn hàng -->
                <div class="order-info">
                    <h4>Thông tin đơn hàng:</h4>
                    <ul>
                        <li><strong>Mã đơn hàng:</strong> {{ $request->vnp_TxnRef }}</li>
                        <li><strong>Tổng cộng:</strong> {{ number_format($request->vnp_Amount / 100, 0, '.', '.') }} VND
                        </li>
                        <li><strong>Ngày thanh toán:</strong> {{ $date }}</li>
                    </ul>
                </div>

                <!-- Các nút điều hướng -->
                <div class="mt-4">
                    <a href="{{ route('index') }}" class="btn btn-primary btn-lg">Quay lại trang chủ</a>
                    <a href="{{ route('client.account.orders') }}" class="btn btn-outline-secondary btn-lg ml-3">Đi đến đơn
                        hàng</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js và jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
@endsection
