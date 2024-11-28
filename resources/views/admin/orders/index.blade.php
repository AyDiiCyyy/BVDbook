@extends('layouts.admin')
@section('title')
    {{ $title ?? 'Quản lý đơn hàng' }}
@endsection
@section('css')
<style>
.status-select {
    transition: background-color 0.3s ease, border-color 0.3s ease;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: #f8f9fa; /* Màu nền mặc định */
    width: 200px; /* Đặt chiều rộng cố định */
}

</style>
@endsection
@section('content')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ $title ?? 'Quản lý đơn hàng' }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <h4 class="m-3 ">Tìm kiếm: </h4>
            <div class="row mb-3">
               
                    <form action="{{ route('admin.order.index') }}" method="GET" class="d-flex">
                        <div class="col-md-2">
                            <label class="form-label">Mã đơn hàng</label>
                            <input type="text" name="order_code" placeholder="Mã đơn hàng" class="form-control"
                                value="{{ $request->order_code ?? '' }}">
                                
                        </div>
                        <div class="col-md-2 d-flex align-items-start justify-content-center align-self-end">
                            <button class="btn btn-primary me-2" type="submit">Tìm kiếm</button>
                           
                        </div>
                    </form>
            
            </div>
           

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Tên người dùng</th>
                        <th scope="col">Mã đơn hàng</th>
                        <th scope="col">Phương thức thanh toán</th>
                        <th scope="col">Trạng thái thanh toán</th> 
                        <th scope="col">Tổng số tiền</th>
                        <th scope="col">Ngày đặt đơn</th> 
                        <th scope="col">Trạng thái đơn hàng</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->user->name }}</td>
                            <td class="text-uppercase ">{{ $order->order_code }}</td>
                            <td>{{ $order->payment == 0 ? 'Ship COD' : 'Thanh toán online' }}</td> 
                            <td>{{ $order->payment_status == 0 ? 'Chưa thanh toán' : 'Đã thanh toán' }}</td> 
                            <td>{{ number_format($order->total_money, 0, ',', '.') }} đ</td>
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td> 
                      
                            <td>
                                <select class="form-select status-select" data-id="{{ $order->id }}" data-current-status="{{ $order->status }}">
                                    @if ($order->status == 1) 
                                        <option value="1" style="color: orange;" selected>Chờ xác nhận</option>
                                        <option value="2" style="color: blue;">Đang xử lý</option>
                                        <option value="5" style="color: red;">Chờ xác nhận hủy đơn</option>
                                    @elseif ($order->status == 2) 
                                        <option value="2" style="color: blue;" selected>Đang xử lý</option>
                                        <option value="3" style="color: green;">Đang giao hàng</option>
                                    @elseif ($order->status == 3) 
                                        <option value="3" style="color: green;" selected>Đang giao hàng</option>
                                        <option value="4" style="color: darkgreen;">Đã giao hàng</option>
                                    @elseif ($order->status == 4) 
                                        <option value="4" style="color: darkgreen;" selected>Đã giao hàng</option>
                                    @elseif ($order->status == 5) 
                                        <option value="5" style="color: red;" selected>Chờ xác nhận hủy đơn</option>
                                        <option value="6" style="color: gray;">Đã hủy</option>
                                    @elseif ($order->status == 6) 
                                        <option value="6" style="color: gray;" selected>Đã hủy</option>
                                    @endif
                                </select>
                            </td>
                            <td>
                                <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-outline-secondary">Xem chi tiết</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center align-items-center p-5">
                {{ $orders->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</main>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var changeStatusUrl = "{{ route('admin.order.changeActive') }}"; 
    </script>
    <script src="{{ asset('js/admin/orderStatus.js') }}"></script>
@endsection
