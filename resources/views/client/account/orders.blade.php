@extends('client.layouts')

@section('title', 'Danh Sách Đơn Hàng')

@section('content')
<style>

/* Sử dụng Flexbox để căn giữa chữ theo chiều ngang và dọc */
.nav-pills {
  display: flex;
  justify-content: space-between; /* Chia đều khoảng cách giữa các tab */
  padding-left: 0;
  margin-bottom: 0;
  list-style: none;
}

.nav-link {
  font-weight: bold;
  border: 1px solid transparent;
  border-radius: 10px;
  padding: 10px 20px;
  transition: background-color 0.3s ease, border-color 0.3s ease;
  color: #4a90e2; /* Màu chữ xanh dương sáng */
  flex: 1; /* Mỗi tab chiếm 1 phần không gian */
  display: flex;
  justify-content: center; /* Căn giữa theo chiều ngang */
  align-items: center; /* Căn giữa theo chiều dọc */
  text-align: center
}

.nav-link.active {
  background-color: #4a90e2; /* Màu nền khi tab đang được chọn */
  color: white; /* Màu chữ trắng khi tab được chọn */
  border-color: #4a90e2; /* Đường viền cũng đổi màu như nền */
}

.nav-link:hover {
  background-color: #e1f5fe; /* Màu nền khi hover nhẹ */
  color: #007bb5; /* Màu chữ khi hover */
  border-color: #007bb5; /* Đổi màu đường viền khi hover */
}

.nav-pills .nav-link {
  margin-right: 15px; /* Khoảng cách giữa các tab */
}

.nav-link span {
  font-size: 12px;
  color: #f76b6b; /* Màu đỏ nhạt cho số lượng */
}






</style>
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
                @include('client.partials.nav_right_order')

                <!-- Danh Sách Đơn Hàng -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            @include('client.partials.nav_order')
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
