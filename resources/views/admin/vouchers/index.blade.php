@extends('layouts.admin')

@section('title')
    Vouchers
@endsection

@section('css')
@endsection

@section('content')
    <main class="app-main"> <!--begin::App Content Header-->
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container"> <!--begin::Row-->
                <div class="row">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="col-sm-6">
                        <h3 class="mb-0">Danh sách Vouchers</h3>
                    </div>
                </div> <!--end::Row-->
            </div> <!--end::Container-->
        </div> <!--end::App Content Header--> <!--begin::App Content-->
        <div class="app-content"> <!--begin::Container-->

            <div class="container">
                <!--begin::Row-->
                <div class="row mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.voucher.create') }}" class="btn btn-success">Thêm mới</a>

                        <!-- Form tìm kiếm và lọc trạng thái -->
                        <form method="GET" action="{{ route('admin.voucher.index') }}" class="d-flex align-items-center">
                            <div class="input-group me-2">
                                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm vouchers"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </div>

                            <div class="ms-2">
                                <select name="status" class="form-select" style="width: 170px;"
                                    onchange="this.form.submit()">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tất cả trạng
                                        thái</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt
                                        động</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Không hoạt động
                                    </option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="container">
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên Voucher</th>
                            <th scope="col">Mã Voucher</th>
                            <th scope="col">Giá Khuyến Mãi</th>
                            <th scope="col">Giới Hạn Sử Dụng</th>
                            <th scope="col">Đơn Hàng Tối Thiểu</th>
                            <th scope="col">Trạng Thái</th>
                            <th scope="col">Ngày Bắt Đầu</th>
                            <th scope="col">Ngày Kết Thúc</th>
                            <th scope="col">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vouchers as $voucher)
                            <tr
                                @if ($voucher->isExpired) style="color: red;" @elseif($voucher->isUpcoming) style="color: orange;" @endif>
                                <td>{{ $voucher->id }}</td>
                                <td>{{ $voucher->name }}</td>
                                <td>{{ $voucher->sku }}</td>
                                <td>{{ number_format($voucher->discount_amount) }} VND</td>
                                <td>{{ $voucher->usage_limit }}</td>
                                <td>{{ number_format($voucher->min_order_amount) }} VND</td>
                                <td>
                                    @if ($voucher->status === 'active')
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-danger">Không hoạt động</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($voucher->start)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($voucher->end)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.voucher.edit', $voucher->id) }}"
                                        class="btn btn-warning btn-sm">Sửa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $vouchers->links() }}
                </div>
            </div>
        </div> <!--end::Container-->
        </div> <!--end::App Content-->
    </main>
@endsection

@section('js')
@endsection
