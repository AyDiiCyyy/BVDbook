@extends('layouts.admin')
@section('title')
    Chi tiết đơn hàng - {{ strtoupper($order->order_code) }}
@endsection

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="mb-0">Chi tiết đơn hàng</h3>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <h5 class="fw-bold m-2">Đơn hàng: <span class="text-uppercase ">{{ $order->order_code }}</span></h5>
                <div class="row">
                    <div class="col-7 h-100">
                        <div class="card mb-4 p-2 ">
                            <div class="card-header">
                                <h5 class="fw-bold">Thông tin sản phẩm</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead class="text-center align-middle">
                                        <tr>
                                            <th style="width: 15%;">Ảnh sản phẩm</th>
                                            <th style="width: 30%;">Tên sản phẩm</th>
                                            <th style="width: 15%;">Số lượng</th>
                                            <th style="width: 15%;">Đơn giá</th>
                                            <th style="width: 20%;">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center align-middle">
                                        @php
                                            $totalAmount = 0;
                                        @endphp
                                        @foreach ($order->OrderDetails as $detail)
                                            @php
                                                $amount = $detail->price * $detail->quantity;
                                                $totalAmount += $amount;
                                            @endphp
                                            <tr>
                                                <td><img src="{{ asset($detail->product->image) }}"
                                                        alt="{{ $detail->product->name }}" class="img-fluid"
                                                        style="max-width: 100px;"></td>
                                                <td>{{ $detail->product->name }}</td>
                                                <td>{{ $detail->quantity }}</td>
                                                <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                                                <td>{{ number_format($amount, 0, ',', '.') }} đ</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card mb-4 p-2 ">
                            <div class="card-header">
                                <h5 class="fw-bold">Thông tin thanh toán</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td style="width:25%;">Tổng tiền sản phẩm:</td>
                                            <td><strong>{{ number_format($totalAmount, 0, ',', '.') }} đ</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Voucher giảm giá:</td>
                                            <td><strong>{{ $order->Voucher ? number_format($order->Voucher->discount_amount, 0, ',', '.') . ' đ' : 'Không có' }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Số tiền phải trả:</td>
                                            <td><strong>{{ number_format($order->total_money, 0, ',', '.') }} đ</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Phương thức thanh toán:</td>
                                            <td><strong>{{ $order->payment == 0 ? 'Ship COD' : 'Thanh toán online' }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Trạng thái thanh toán:</td>
                                            <td><strong
                                                    class="{{ $order->payment_status == 0 ? 'text-warning' : 'text-success' }}">
                                                    {{ $order->payment_status == 0 ? 'Chưa thanh toán' : 'Đã thanh toán' }}
                                                </strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="fw-bold ">Thông tin đặt hàng</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td style="width:25%;">Mã đơn hàng:</td>
                                            <td><strong class="text-uppercase ">{{ $order->order_code }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Tên người nhận:</td>
                                            <td><strong>{{ $order->name }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Số điện thoại:</td>
                                            <td><strong>{{ $order->phone }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td><strong>{{ $order->user->email }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Ngày đặt hàng:</td>
                                            <td><strong
                                                    class="text-uppercase ">{{ $order->created_at->format('d/m/Y') }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="fw-bold">Địa chỉ nhận hàng</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-uppercase ">{{ $order->address }}</p>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="fw-bold">Trạng thái đơn hàng</h5>
                            </div>
                            <div class="card-body">
                                @if ($order->payment == 1 && $order->payment_status == 0)
                                    <h5 class="text-danger">Chờ thanh toán lại</h5>
                                @else
                                    @if ($order->status == 5)
                                        <h5 class="text-warning">Chờ xác nhận hủy đơn</h5>
                                    @elseif($order->status == 1)
                                        <h5 class="text-warning">Chờ xác nhận</h5>
                                    @elseif($order->status == 2)
                                        <h5 class="text-warning">Đang xử lý</h5>
                                    @elseif($order->status == 3)
                                        <h5 class="text-info">Đang giao hàng</h5>
                                    @elseif($order->status == 4)
                                        <h5 class="text-success">Đã giao hàng</h5>
                                    @elseif($order->status == 6)
                                        <h5 class="text-danger">Đã hủy</h5>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
