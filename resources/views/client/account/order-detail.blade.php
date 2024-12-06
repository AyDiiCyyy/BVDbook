@extends('client.layouts')

@section('title', 'Chi Tiết Đơn Hàng')

@section('content')
    <section class="breadcrumb-area bg-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="breadcrumb-heading">Chi Tiết Đơn Hàng</h1>
                    <ul class="breadcrumb-links">
                        <li><a href="#">Trang Chủ</a></li>
                        <li><a href="{{ route('client.account.orders') }}">Đơn Hàng</a></li>
                        <li>Chi Tiết Đơn Hàng</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="account-area mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <a href="{{ route('my-account') }}" class="list-group-item list-group-item-action">Hồ Sơ</a>
                        <a href="{{ route('client.account.update-profile') }}"
                            class="list-group-item list-group-item-action">Thông Tin</a>
                        <a href="{{ route('client.account.orders') }}" class="list-group-item list-group-item-action">Đơn
                            Hàng</a>
                        <a href="#" class="list-group-item list-group-item-action">Voucher</a>
                        <a href="{{ route('client.account.change-password.form') }}"
                            class="list-group-item list-group-item-action">Đổi Mật Khẩu</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a href="#" class="btn btn-danger mt-3"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng Xuất</a>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="fw-bold mb-0">Chi Tiết Đơn hàng #<span
                                    class="text-uppercase ">{{ $order->order_code }}</span></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6 class="fw-bold">Thông tin sản phẩm</h6>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Ảnh sản phẩm</th>
                                                        <th>Tên sản phẩm</th>
                                                        <th>Số lượng</th>
                                                        <th>Đơn giá</th>
                                                        <th>Thành tiền</th>
                                                        @if ($order->status == 4 && $order->payment_status == 1)
                                                            <th>Hành động</th>
                                                        @endif

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalAmount = 0;
                                                    @endphp
                                                    @foreach ($order->OrderDetails as $detail)
                                                        @php
                                                            $amount = $detail->unit_price * $detail->quantity;
                                                            $totalAmount += $amount;
                                                        @endphp
                                                        <tr>
                                                            <td><img src="{{ asset($detail->product->image) }}"
                                                                    alt="{{ $detail->product->name }}" class="img-fluid"
                                                                    style="max-width: 100px;"></td>
                                                            <td>{{ $detail->product->name }}</td>
                                                            <td>{{ $detail->quantity }}</td>
                                                            <td>{{ number_format($detail->unit_price, 0, ',', '.') }} đ
                                                            </td>
                                                            <td>{{ number_format($amount, 0, ',', '.') }} đ</td>
                                                            @if ($order->status == 4 && $order->payment_status == 1 && $detail->active == 0)
                                                                <td>

                                                                    <form 
                                                                   
                                                                        action="{{ route('productDetail', ['slug' => $detail->product->slug]) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="oder_detail_id"
                                                                            value="{{ $detail->id }}">
                                                                        <button type="submit"
                                                                            class="btn btn-warning btn-sm">Đánh giá
                                                                        </button>

                                                                    </form>
                                                                </td>
                                                            @elseif ($order->status == 4 && $order->payment_status == 1 && $detail->active == 1)
                                                                <td>
                                                                    <p>Bạn đã đánh giá sản phẩm này </p>

                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6 class="fw-bold">Thông tin thanh toán</h6>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td>Tổng tiền sản phẩm:</td>
                                                        <td><strong>{{ number_format($totalAmount, 0, ',', '.') }}
                                                                đ</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Phương thức thanh toán:</td>
                                                        <td><strong>{{ $order->payment == 1 ? 'Ship COD' : 'Thanh toán online' }}</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Voucher giảm giá:</td>
                                                        <td><strong>{{ $order->Voucher ? number_format($order->Voucher->discount_amount, 0, ',', '.') . ' đ' : 'Không có' }}</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Số tiền phải trả:</td>
                                                        <td><strong>{{ number_format($totalAmount - ($order->Voucher ? $order->Voucher->discount_amount : 0), 0, ',', '.') }}
                                                                đ</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h6 class="fw-bold">Thông tin đặt hàng</h6>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td>Mã đơn hàng:</td>
                                                        <td><strong
                                                                class="text-uppercase">{{ $order->order_code }}</strong>
                                                        </td>
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
                                                        <td><strong>{{ $order->User->email }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ngày đặt hàng:</td>
                                                        <td><strong>{{ $order->created_at->format('d/m/Y') }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Trạng thái đơn hàng:</td>
                                                        <td><strong class="text-success">{{ $orderStatusLabel }}</strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            {{-- @if ($order->status != 4 && $order->status != 5)
                                                <form action="{{ route('client.orders.cancel', $order->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-danger w-100">Hủy đơn
                                                        hàng</button>
                                                </form>
                                            @endif --}}
                                        </div>
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h6 class="fw-bold">Địa chỉ nhận hàng</h6>
                                            </div>
                                            <div class="card-body">
                                                <p>{{ $order->address }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
