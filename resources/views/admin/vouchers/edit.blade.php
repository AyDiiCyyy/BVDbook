@extends('layouts.admin')

@section('title')
    Update Vouchers
@endsection

@section('css')
@endsection

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Cập nhật Voucher</h3>
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
                            <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <!-- Tên Voucher -->
                                    <div class="mb-3">
                                        <label class="form-label">Tên Voucher</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name', $voucher->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- SKU -->
                                    <div class="mb-3">
                                        <label class="form-label">Mã Voucher</label>
                                        <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku"
                                            value="{{ old('sku', $voucher->sku) }}">
                                        @error('sku')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Giảm giá (Discount Amount) -->
                                    <div class="mb-3">
                                        <label class="form-label">Số tiền giảm</label>
                                        <input type="number" class="form-control @error('discount_amount') is-invalid @enderror" name="discount_amount"
                                            value="{{ old('discount_amount', $voucher->discount_amount) }}">
                                        @error('discount_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Số lượng giới hạn (Usage Limit) -->
                                    <div class="mb-3">
                                        <label class="form-label">Giới hạn sử dụng</label>
                                        <input type="number" class="form-control @error('usage_limit') is-invalid @enderror" name="usage_limit"
                                            value="{{ old('usage_limit', $voucher->usage_limit) }}">
                                        @error('usage_limit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Số tiền tối thiểu (Min Order Amount) -->
                                    <div class="mb-3">
                                        <label class="form-label">Số tiền tối thiểu</label>
                                        <input type="number" class="form-control @error('min_order_amount') is-invalid @enderror" name="min_order_amount"
                                            value="{{ old('min_order_amount', $voucher->min_order_amount) }}">
                                        @error('min_order_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
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
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description', $voucher->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Ngày bắt đầu (Start Date) -->
                                <div class="mb-3">
                                    <label class="form-label">Ngày bắt đầu</label>
                                    <input type="date" class="form-control @error('start') is-invalid @enderror" name="start"
                                        value="{{ old('start', $voucher->start ? \Carbon\Carbon::parse($voucher->start)->format('Y-m-d') : '') }}">
                                    @error('start')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Ngày kết thúc (End Date) -->
                                <div class="mb-3">
                                    <label class="form-label">Ngày kết thúc</label>
                                    <input type="date" class="form-control @error('end') is-invalid @enderror" name="end"
                                        value="{{ old('end', $voucher->end ? \Carbon\Carbon::parse($voucher->end)->format('Y-m-d') : '') }}">
                                    @error('end')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="mb-3 d-flex justify-content-center mt-5">
                                    <button type="submit" class="btn btn-success">Cập nhật</button>
                                    <a href="{{ route('vouchers.index') }}" class="btn btn-info ms-3">Danh sách</a>
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
