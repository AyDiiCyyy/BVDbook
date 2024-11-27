@extends('client.layouts')

@section('title', 'Chi Tiết Đơn Hàng')

@section('content')
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-heading">Chi Tiết Đơn Hàng</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="#">Trang Chủ</a></li>
                            <li><a href="{{ route('client.account.orders') }}">Đơn Hàng</a></li>
                            <li>Chi Tiết Đơn Hàng</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="account-area mtb-60px">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <a href="{{ route('my-account') }}" class="list-group-item list-group-item-action">Hồ Sơ</a>
                        <a href="{{ route('client.account.update-profile') }}" class="list-group-item list-group-item-action">thông tin</a>
                        <a href="{{ route('client.account.orders') }}" class="list-group-item list-group-item-action">Đơn Hàng</a>
                        <a href="#" class="list-group-item list-group-item-action">Voucher</a>
                        <a href="{{ route('client.account.change-password.form') }}"class="list-group-item list-group-item-action">Đổi Mật Khẩu</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a href="#" class="btn btn-danger mt-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng Xuất</a>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h5>Chi Tiết Đơn Hàng #{{ $order->sku }}</h5>
                        </div>
                        <div class="card-body">
                            <h5>Sản Phẩm trong Đơn Hàng</h5>
                            @foreach($order->orderDetails as $item)  
                                <div class="order-item">
                                    <p><strong>Tên Sản Phẩm:</strong> {{ $item->product->name }}</p> 
                                    <p><strong>Số Lượng:</strong> {{ $item->quantity }}</p>
                                    <p><strong>Giá:</strong> {{ number_format($item->price, 0, ',', '.') }} VND</p>
                                    <hr>
                                </div>
                            @endforeach

                            @if($order->status != 4 && $order->status != 5) 
                            <form action="{{ route('client.orders.cancel', $order->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('PATCH') 
                                <button type="submit" class="btn btn-danger">Hủy Mua Hàng</button>
                            </form>
                        @else
                            <p class="text-muted">Đơn hàng không thể hủy do đã hoàn thành hoặc đã bị hủy.</p>
                        @endif
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
