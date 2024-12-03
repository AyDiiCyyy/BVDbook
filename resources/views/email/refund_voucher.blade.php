<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoàn tiền Voucher</title>
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            border-radius: 8px;
        }

        .email-header {
            background-color: #2c3e50;
            color: #ffffff;
            text-align: center;
            padding: 30px 0;
            border-radius: 8px 8px 0 0;
        }

        .email-header h1 {
            font-size: 28px;
            margin: 0;
        }

        .email-header p {
            font-size: 16px;
            margin: 5px 0 0;
        }

        .card {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            background-color: #ecf0f1;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: #e74c3c;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .voucher-info {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .voucher-info p {
            margin: 10px 0;
            font-size: 16px;
        }

        .voucher-info strong {
            color: #34495e;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: #7f8c8d;
            font-size: 14px;
        }

        .footer a {
            color: #2c3e50;
            text-decoration: none;
        }

        .footer a:hover {
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

        <!-- Voucher Information -->
        <div class="card">
            <h4 class="card-title">Thông tin Voucher</h4>
            <div class="voucher-info">
                <p><strong>Mã voucher:</strong> <span style="color: #16a085;">{{ $voucherCode }}</span></p>
                <p><strong>Giá trị voucher:</strong> <span style="color: #e74c3c;">{{ number_format($voucherAmount, 0, ',', '.') }} VND</span></p>
                <p><strong>Ngày hết hạn:</strong> <span style="color: #e67e22;">{{ $expiryDate }}</span></p>
                <p>Voucher này chỉ có thể sử dụng một lần.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} BVD BOOK. Tất cả các quyền được bảo lưu.</p>
            <p><a href="#">Liên hệ với chúng tôi</a></p>
        </div>
    </div>
</body>

</html>