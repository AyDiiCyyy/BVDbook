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

            <div class="container"> <!--begin::Row-->
                <div class="row">
                    <div class="d-flex justify-content-end ">
                        <a href="{{ route('vouchers.create') }}" class="btn btn-success">Thêm mới</a>
                    </div>
                </div>
            </div>
            <div class="container"> <!--begin::Row-->
                <form action="{{ route('vouchers.index') }}" method="GET">
                    <div class="form-group">
                        <label for="status" class="label-control">Lọc voucher:</label>
                        <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                            <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                            <option value="deleted" {{ $status == 'deleted' ? 'selected' : '' }}>Đã xóa</option>
                        </select>
                    </div>
                </form>
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
                            <th scope="col">Giá Đơn Tối Thiểu</th>
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
                                    @if ($voucher->isExpired)
                                        <span class="badge bg-danger">Đã hết hạn</span>
                                    @elseif($voucher->isUpcoming)
                                        <span class="badge bg-info">Sắp ra mắt</span>
                                    @else
                                        <span class="badge bg-success">Còn hiệu lực</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($voucher->start)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($voucher->end)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($voucher->deleted_at)
                                        {{-- Hiển thị nút Khôi phục cho voucher đã bị xóa --}}
                                        <a href="{{ route('vouchers.restore', $voucher->id) }}"
                                            class="btn btn-warning btn-sm">Khôi phục</a>
                                        <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn?')"
                                                class="btn btn-danger btn-sm">Xóa vĩnh viễn</button>
                                        </form>
                                    @else
                                        {{-- Hiển thị nút Sửa và Xóa cho voucher chưa bị xóa --}}
                                        <a href="{{ route('vouchers.edit', $voucher->id) }}"
                                            class="btn btn-warning btn-sm">Sửa</a>
                                        <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                                                class="btn btn-danger btn-sm">Xóa</button>
                                        </form>
                                    @endif
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
