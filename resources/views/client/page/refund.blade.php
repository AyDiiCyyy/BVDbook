@extends('client.layouts')

@section('title')
    Chính Sách Đổi / Trả / Hoàn Tiền
@endsection

@section('content')
<style>
    .policy-page {
        background: linear-gradient(45deg, #e3f2fd, #90caf9);
        padding: 50px 0;
        min-height: 88vh;
    }

    .policy-card {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .policy-card h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 20px;
        text-align: center;
        border-bottom: 3px solid #28a745;
        padding-bottom: 10px;
    }

    .policy-card h3 {
        font-size: 1.7rem;
        color: #343a40;
        margin-top: 20px;
        margin-bottom: 10px;
        font-weight: 600;
        border-left: 5px solid #28a745;
        padding-left: 15px;
    }

    .policy-card p {
        font-size: 1.1rem;
        color: #6c757d;
        line-height: 1.8;
        margin-bottom: 15px;
    }

    .policy-card ul {
        list-style: none;
        padding: 0;
    }

    .policy-card ul li {
        position: relative;
        padding-left: 25px;
        margin-bottom: 10px;
        font-size: 1.1rem;
        color: #495057;
        transition: color 0.3s;
    }

    .policy-card ul li:hover {
        color: #28a745;
    }

    .policy-card ul li::before {
        content: '\2022';
        position: absolute;
        left: 0;
        color: #28a745;
        font-size: 1.5rem;
    }

    .btn-back {
        display: inline-block;
        margin-top: 20px;
        font-size: 1.2rem;
        padding: 12px 25px;
        color: #ffffff;
        background: linear-gradient(45deg, #007bff, #0056b3);
        border-radius: 50px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .btn-back:hover {
        background: linear-gradient(45deg, #0056b3, #007bff);
    }

    .breadcrumb-area {
        background: linear-gradient(45deg, #e3f2fd, #90caf9);
        padding: 30px 0;
    }

    .breadcrumb-content {
        text-align: center;
    }

    .breadcrumb-hrading {
        font-size: 2.5rem;
        font-weight: 700;
        color: #0d47a1;
    }

    .breadcrumb-links {
        list-style: none;
        padding: 0;
        display: inline-flex;
        margin-top: 10px;
    }

    .breadcrumb-links li {
        font-size: 1.1rem;
        color: #0d47a1;
        margin-right: 5px;
    }

    .breadcrumb-links li a {
        color: #0d47a1;
        text-decoration: none;
    }

    .breadcrumb-links li a:hover {
        text-decoration: underline;
    }
</style>

<section class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-hrading">Chính Sách Đổi / Trả / Hoàn Tiền</h1>
                    <ul class="breadcrumb-links">
                        <li><a href="{{ route('index') }}">Trang Chủ</a></li>
                        <li>/ Chính Sách</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="policy-page">
    <div class="container">
        <div class="policy-card">
            <h1>Chính Sách Đổi / Trả / Hoàn Tiền</h1>

            <h3>1. Điều kiện đổi/trả sản phẩm</h3>
            <p>Sản phẩm sẽ được đổi/trả nếu đáp ứng đầy đủ các điều kiện sau:</p>
            <ul>
                <li>Sản phẩm bị lỗi do nhà sản xuất (sai nội dung in ấn, thiếu trang, trang rách, mờ chữ, lỗi bìa).</li>
                <li>Sản phẩm giao không đúng theo đơn hàng (sai tiêu đề sách, số lượng, hoặc mẫu mã).</li>
                <li>Sản phẩm còn nguyên vẹn, không bị dơ bẩn, không có dấu hiệu sử dụng hoặc hư hại do người dùng.</li>
                <li>Yêu cầu đổi/trả được thực hiện trong vòng <strong>7 ngày</strong> kể từ ngày nhận hàng.</li>
            </ul>

            <h3>2. Quy trình đổi/trả sản phẩm</h3>
            <p>Để yêu cầu đổi/trả, vui lòng thực hiện theo các bước sau:</p>
            <ul>
                <li><strong>Liên hệ với chúng tôi:</strong> Gọi hotline hoặc gửi email hỗ trợ.</li>
                <li><strong>Cung cấp thông tin:</strong> Số đơn hàng và hình ảnh sản phẩm lỗi.</li>
                <li><strong>Hoàn trả sản phẩm:</strong> Đóng gói sản phẩm và gửi về địa chỉ của cửa hàng.</li>
            </ul>

            <h3>3. Chính sách hoàn tiền</h3>
            <p>Chúng tôi áp dụng hoàn tiền trong các trường hợp sau:</p>
            <ul>
                <li>Không còn sản phẩm thay thế cho trường hợp đổi hàng.</li>
                <li>Sản phẩm lỗi nghiêm trọng không thể khắc phục.</li>
            </ul>
            <p>Thời gian xử lý hoàn tiền: <strong>5 - 7 ngày làm việc</strong> kể từ khi yêu cầu được phê duyệt.</p>

            <h3>4. Lưu ý quan trọng</h3>
            <ul>
                <li>Sản phẩm không thuộc danh mục đổi/trả: sách giảm giá, sách tặng kèm, hoặc sản phẩm có dấu hiệu sử dụng không đúng cách.</li>
                <li>BVDbook có quyền từ chối đổi/trả/hoàn tiền nếu sản phẩm không đáp ứng đủ điều kiện đã nêu.</li>
            </ul>
            <div class="d-flex justify-content-center">
                <a href="{{ route('index') }}" class="btn-back text-center">Quay về Trang Chủ</a>
            </div>
        </div>
    </div>
</section>
@endsection
