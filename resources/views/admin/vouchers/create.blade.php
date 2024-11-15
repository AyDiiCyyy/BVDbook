@extends('layouts.admin')

@section('title')
    Create Vouchers
@endsection

@section('css')
@endsection

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Thêm mới Voucher</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row g-4">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="card card-primary card-outline mb-4">
                            <form action="{{ route('vouchers.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <!-- Tên Voucher -->
                                    <div class="mb-3">
                                        <label class="form-label">Tên Voucher</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- SKU -->
                                    <div class="mb-3">
                                        <label class="form-label">Mã Voucher</label>
                                        <input type="text" class="form-control" name="sku"
                                            value="{{ old('sku') }}">
                                        @error('sku')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Giảm giá (Discount Amount) -->
                                    <div class="mb-3">
                                        <label class="form-label">Số tiền giảm</label>
                                        <input type="number" class="form-control" name="discount_amount"
                                            value="{{ old('discount_amount') }}">
                                        @error('discount_amount')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Số lượng giới hạn (Usage Limit) -->
                                    <div class="mb-3">
                                        <label class="form-label">Giới hạn sử dụng</label>
                                        <input type="number" class="form-control" name="usage_limit"
                                            value="{{ old('usage_limit') }}">
                                        @error('usage_limit')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Đơn Hàng tối thiểu (Min Order Amount) -->
                                    <div class="mb-3">
                                        <label class="form-label">Đơn Hàng tối thiểu</label>
                                        <input type="number" class="form-control" name="min_order_amount"
                                            value="{{ old('min_order_amount') }}">
                                        @error('min_order_amount')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="card card-primary card-outline mb-4">
                            <div class="card-body">
                                <!-- Mô tả -->
                                <div class="mb-3">
                                    <label class="form-label">Mô tả</label>
                                    <textarea class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Ngày bắt đầu (Start Date) -->
                                <div class="mb-3">
                                    <label class="form-label">Ngày bắt đầu</label>
                                    <input type="date" class="form-control" name="start" value="{{ old('start') }}">
                                    @error('start')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Ngày kết thúc (End Date) -->
                                <div class="mb-3">
                                    <label class="form-label">Ngày kết thúc</label>
                                    <input type="date" class="form-control" name="end" value="{{ old('end') }}">
                                    @error('end')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="mb-3 d-flex justify-content-center mt-5">
                                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
@endsection
