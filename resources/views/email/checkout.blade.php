<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .email-header {
            background-color: #2c3e50;
            color: #ffffff;
            text-align: center;
            padding: 20px 0;
        }

        .email-header h1 {
            font-size: 24px;
            margin: 0;
        }

        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }

        .card-title {
            color: #e74c3c;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #34495e;
            color: #ffffff;
        }

        .order-summary {
            background-color: #ecf0f1;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: #7f8c8d;
            font-size: 14px;
        }

        .tracking-link {
            color: #3498db;
            text-decoration: none;
        }

        .tracking-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="email-header">
            <h1>BVD BOOK</h1>
            <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi!</p>
        </div>

        <!-- Order Information -->
        <div class="card">
            <h4 class="card-title">Thông tin đơn hàng</h4>
            <p><strong>Mã đơn hàng:</strong> <span style="color: #16a085;">{{ $order->order_code }}</span></p>
            <p><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</p>
            <p><strong>Phương thức thanh toán:</strong> <span style="color: #8e44ad;">
                {{ $order->payment == 0 ? 'Thanh toán khi nhận hàng' : 'Thanh toán VNPay' }}
            </span></p>
        </div>

        <!-- Order Items -->
        <div class="card">
            <h4 class="card-title">Chi tiết đơn hàng</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sum = 0;
                    @endphp
                    @foreach ($order->OrderDetails as $item)
                    @php
                        $sum += ($item->price*$item->quantity)
                    @endphp
                    <tr>
                        <td>{{ $item->Product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 0, '.', '.') }} VND</td>
                        <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Order Summary -->
        <div class="card order-summary">
            @if ($order?->Voucher?->id != 0)
            <p><strong>Tổng tiền:</strong> <span style="color: #e74c3c;">
                {{ number_format($sum, 0, '.', '.') }} VND
            </span></p>
            <p><strong>Giảm giá:</strong> <span style="color: #3498db;">
                - {{ number_format($order->Voucher->discount_amount, 0, '.', '.') }} VND
            </span></p>
            @else
            <p><strong>Tổng tiền:</strong> <span style="color: #e74c3c;">
                {{ number_format($order->total_money, 0, '.', '.') }} VND
            </span></p>
            <p><strong>Giảm giá:</strong> <span style="color: #3498db;">
                - 0 VND
            </span></p>
            @endif
            <p><strong>Tổng thanh toán:</strong> <span style="color: #2ecc71;">
                {{ number_format($order->total_money, 0, '.', '.') }} VND
            </span></p>
        </div>

        <!-- Tracking Info -->
        <div class="card">
            <h4 class="card-title">Theo dõi đơn hàng</h4>
            <p>Click vào <a href="{{ route('index') }}" class="tracking-link">đây</a> để theo dõi tiến độ giao hàng của bạn.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} BVD BOOK. Tất cả các quyền được bảo lưu.</p>
        </div>
    </div>
</body>

</html>
