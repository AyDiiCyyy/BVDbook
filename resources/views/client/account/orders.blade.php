@extends('client.layouts')

@section('title', 'Danh Sách Đơn Hàng')

@section('content')
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-heading">Danh Sách Đơn Hàng</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="#">Trang Chủ</a></li>
                            <li>Đơn Hàng</li>
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
                        <a href="{{ route('client.account.update-profile') }}" class="list-group-item list-group-item-action">Thông Tin</a>
                        <a href="{{ route('client.account.orders') }}" class="list-group-item list-group-item-action">Đơn Hàng</a>
                        <a href="#" class="list-group-item list-group-item-action">Voucher</a>
                        <a href="{{ route('client.account.change-password.form') }}"class="list-group-item list-group-item-action">Đổi Mật Khẩu</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a href="#" class="btn btn-danger mt-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng Xuất</a>
                    </div>
                </div>

                <!-- Danh Sách Đơn Hàng -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h5>Danh Sách Đơn Hàng</h5>
                        </div>
                        <div class="card-body">
                            @if($orders->isEmpty())
                                <p>Không có đơn hàng nào.</p>
                            @else
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Mã Đơn Hàng</th>
                                            <th>Ngày Mua</th>
                                            <th>Tổng Tiền</th>
                                            <th>Trạng Thái</th>
                                            <th>Hành Động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $order->order_code  }}</td>
                                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                                <td>{{ number_format($order->total_money, 0, ',', '.') }} VND</td>
                                                <td>
                                                    <span class="badge bg-{{ $order->status === 4 ? 'success' : 'warning' }}">
                                                        {{ $order->status_label }}
                                                    </span>
                                                </td>                                                
                                                <td>
                                                    <a href="{{ route('client.account.order-detail', $order->id) }}" class="btn btn-info btn-sm">Xem Chi Tiết</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
