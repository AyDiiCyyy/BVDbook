@extends('client.layouts')

@section('title', 'Kho Voucher của Bạn')

@section('content')
<style>
/* Tổng thể */
.voucher-list {
    margin-top: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Tăng khoảng cách giữa các voucher */
}

.voucher-item {
    flex: 1 1 calc(50% - 20px); /* Mỗi voucher chiếm 50% chiều rộng của hàng */
    min-width: 250px; /* Kích thước tối thiểu của voucher */
    min-height: 180px; /* Tăng chiều cao của voucher */
    background: linear-gradient(135deg, #f0f8ff, #e6f7ff);
    border: 1px solid #e0e0e0;
    border-radius: 15px;
    padding: 20px; /* Tăng padding cho voucher */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.3s, box-shadow 0.3s;
}

.voucher-item:hover {
    transform: translateY(-8px);
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
    border: 1px solid #007bff;
}

/* Nội dung voucher */
.voucher-content {
    width: 100%;
    font-size: 1rem; /* Tăng kích thước font */
    line-height: 1.6;
    color: #333;
}

.voucher-title {
    font-size: 1.15rem;
    font-weight: bold;
    color: #007bff;
}

.voucher-discount,
.voucher-minimum,
.voucher-expiry {
    font-size: 1rem;
    margin-top: 5px;
}

.voucher-discount {
    color: #28a745;
}

.voucher-minimum {
    color: #555;
}

.voucher-minimum .text-primary {
    font-weight: bold;
    color: #007bff;
}

.voucher-expiry {
    color: #666;
}

.voucher-expiry .text-warning {
    font-weight: bold;
    color: #d9534f;
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

/* Media Queries */
@media screen and (max-width: 768px) {
    .voucher-item {
        flex: 1 1 calc(50% - 20px); /* 2 voucher mỗi hàng trên màn hình vừa */
    }
}

@media screen and (max-width: 480px) {
    .voucher-item {
        flex: 1 1 calc(50% - 20px); /* 2 voucher mỗi hàng trên màn hình nhỏ */
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

/* Media Queries */
@media screen and (max-width: 768px) {
    .voucher-item {
        flex: 1 1 calc(50% - 20px); /* 2 voucher mỗi hàng trên màn hình vừa */
    }
}

@media screen and (max-width: 480px) {
    .voucher-item {
        flex: 1 1 100%; /* 1 voucher mỗi hàng trên màn hình nhỏ */
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
                    <h1 class="breadcrumb-heading">Kho voucher của bạn</h1>
                    <ul class="breadcrumb-links">
                        <li><a href="#">Trang Chủ</a></li>
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
            <!-- Danh Sách Voucher -->
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

                        <!-- Danh sách voucher -->
                        <div class="voucher-list mt-4">
                            <!-- Voucher mẫu -->
                            @foreach ($voucher as $item)
                            <div class="voucher-item">
                                <div class="voucher-content">
                                    <p class="voucher-title">{{$item->name}}</p>
                                    <p class="voucher-discount">Giảm: <span class="text-success">{{ number_format($item->discount_amount, 0, '.', '.') }} ₫</span></p>
                                    <p class="voucher-minimum">Áp dụng cho đơn từ: <span class="text-primary">{{ number_format($item->min_order_amount, 0, '.', '.') }} ₫</span></p>
                                    <p class="voucher-expiry">Hạn sử dụng: <span class="text-warning">{{ date('d/m/Y', strtotime($item->end)) }}</span></p>
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
@endsection
