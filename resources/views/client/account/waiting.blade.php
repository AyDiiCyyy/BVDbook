@extends('client.layouts')

@section('title', 'Danh Sách Đơn Hàng')

@section('content')
    <style>
        /* Sử dụng Flexbox để căn giữa chữ theo chiều ngang và dọc */
        .nav-pills {
            display: flex;
            justify-content: space-between;
            /* Chia đều khoảng cách giữa các tab */
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
            color: #4a90e2;
            /* Màu chữ xanh dương sáng */
            flex: 1;
            /* Mỗi tab chiếm 1 phần không gian */
            display: flex;
            justify-content: center;
            /* Căn giữa theo chiều ngang */
            align-items: center;
            /* Căn giữa theo chiều dọc */
            text-align: center
        }

        .nav-link.active {
            background-color: #4a90e2;
            /* Màu nền khi tab đang được chọn */
            color: white;
            /* Màu chữ trắng khi tab được chọn */
            border-color: #4a90e2;
            /* Đường viền cũng đổi màu như nền */
        }

        .nav-link:hover {
            background-color: #e1f5fe;
            /* Màu nền khi hover nhẹ */
            color: #007bb5;
            /* Màu chữ khi hover */
            border-color: #007bb5;
            /* Đổi màu đường viền khi hover */
        }

        .nav-pills .nav-link {
            margin-right: 15px;
            /* Khoảng cách giữa các tab */
        }

        .nav-link span {
            font-size: 12px;
            color: #f76b6b;
            /* Màu đỏ nhạt cho số lượng */
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
                            <li>{{$nav}}</li>
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
                            @if ($orders->isEmpty())
                                <p>Không có đơn hàng nào.</p>
                            @else
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Mã Đơn Hàng</th>
                                            <th>Ngày Mua</th>
                                            <th class="text-center">Tổng Tiền</th>
                                            <th class="text-center">Trạng Thái Đơn Hàng</th>
                                            <th class="text-center">Trạng Thái Thanh Toán</th>
                                            <th class="text-center">Phương Thức Thanh Toán</th>
                                            <th class="text-center">Hành Động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-center"><a class="text-reset text-decoration-none" href="{{ route('client.account.order-detail', $order->id) }}">{{ $order->order_code }}</a></td>
                                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ number_format($order->total_money, 0, '.', '.') }} VND</td>
                                                <td class="text-center">
                                                    @switch($order->status)
                                                        @case(1)
                                                            <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                                                        @break

                                                        @case(2)
                                                            <span class="badge bg-primary">Đang xử lý</span>
                                                        @break

                                                        @case(3)
                                                            <span class="badge bg-info text-dark">Đang Giao Hàng</span>
                                                        @break

                                                        @case(4)
                                                            <span class="badge bg-success">Đã giao hàng</span>
                                                        @break

                                                        @case(5)
                                                            <span class="badge bg-orange bg-danger">Chờ xác nhận hủy đơn</span>
                                                        @break

                                                        @case(6)
                                                            <span class="badge bg-danger">Hủy đơn</span>
                                                        @break

                                                        @default
                                                            <span class="badge bg-secondary">Không xác định</span>
                                                    @endswitch

                                                </td>
                                                <td class="text-center">
                                                    @switch($order->payment_status)
                                                        @case(0)
                                                            <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                                        @break

                                                        @case(1)
                                                            <span class="badge bg-primary">Đã thanh toán</span>
                                                        @break

                                                        @default
                                                            <span class="badge bg-secondary">Không xác định</span>
                                                    @endswitch

                                                </td>
                                                <td class="text-center">
                                                    @switch($order->payment)
                                                        @case(0)
                                                            <span class="badge bg-warning text-dark">Thanh toán khi nhận hàng</span>
                                                        @break

                                                        @case(1)
                                                            <span class="badge bg-primary">Thanh toán VNPay</span>
                                                        @break

                                                        @default
                                                            <span class="badge bg-secondary">Không xác định</span>
                                                    @endswitch

                                                </td>
                                                <td style="white-space: nowrap;">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        @if ($order->payment == 1 && $order->payment_status == 0 && $order->status == 1)
                                                            <form action="{{ route('repayment', ['id'=>$order->id]) }}" method="POST" class="d-inline me-2">
                                                                @csrf
                                                                <button type="submit" name="redirect" value="cocainit" class="btn btn-success btn-sm ms-2">Thanh toán</button>
                                                            </form>
                                                        @endif
                                                        @if ($order->status == 1)
                                                        <form action="{{ route('client.account.orders.cancel', ['id'=>$order->id]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm">Hủy Đơn</button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </td>
                                                
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center align-items-center p-5">
                                    {{ $orders->links('pagination::bootstrap-4') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
