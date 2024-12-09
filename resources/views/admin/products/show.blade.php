@extends('layouts.admin')
@section('title')
@endsection
@section('css')
@endsection
@section('content')
    <main class="app-main"> <!--begin::App Content Header-->
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">{{ $product->name }}</h3>
                    </div>
                    {{-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            General Form
                        </li>
                    </ol>
                </div> --}}
                </div> <!--end::Row-->
            </div> <!--end::Container-->
        </div> <!--end::App Content Header--> <!--begin::App Content-->
        <div class="app-content">
            <div class="container-fluid">
                <!-- Product Detail Section -->
                <div class="row">
                    <!-- Product Image -->
                    <div class="col-md-6">
                        <div class="card  m-3">
                            <div class="card-header text-center fw-bold">Ảnh đại diện</div>
                            <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                        </div>
                        <div class="card  m-3">
                            <div class="card-header text-center fw-bold">Ảnh liên quan</div>
                            <div class="card-body">
                                <div class="row g-2">
                                    @foreach($product->galleries as $gallery)
                                        <div class="col-4">
                                            <div class="card">
                                                <img src="{{ $gallery->image }}" class="card-img-top" alt="Ảnh liên quan">
                                                <div class="card-body text-center p-2">
                                                    <p class="text-muted small mb-1">Ngày: {{ $gallery->created_at->format('d/m/Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="col-md-6">
                        <div class="card m-3">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <h5 class="text-center fw-bold text-uppercase">Thông tin sản phẩm</h5>
                                </div>
                               
                                <div class="row mb-3">
                                    <p class="card-text fs-5">
                                        <strong>Tên sản phẩm:</strong> {{ $product->name }}
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Đường dẫn :</strong> {{ $product->slug }}
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Mã sản phẩm:</strong> {{ $product->sku }}
                                    </p>
                                    
                                    <p class="card-text fs-5">
                                        <strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} đ
                                    </p>
                                    @if($product->sale ?? '')
                                    <p class="card-text fs-5">
                                        <strong>Giá giảm:</strong> {{ number_format($product->sale, 0, ',', '.') }} đ
                                    </p>
                                    @endif
                                    <p class="card-text fs-5">
                                        <strong>Danh mục:</strong> {{ implode(',', $categoriesOfProduct) ?? ''}}
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Tác giả:</strong> {{ $product->author }}
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Nhà xuất bản:</strong> {{ $product->publisher }}
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Năm xuất bản:</strong> {{ $product->released }}
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Cân nặng:</strong> {{ $product->weight }}
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Số trang:</strong> {{ $product->page }}
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Số lượng :</strong> {{ $product->quantity }}
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Số thứ tự :</strong> {{ $product->order }}
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Nổi bật:</strong>
                                        @if ($product->best === 1)
                                            <span class="badge bg-success">Nổi bật</span>
                                        @else
                                            <span class="badge bg-danger">Không nổi bật</span>
                                        @endif
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Trạng thái:</strong>
                                        @if ($product->active === 1)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-danger">Không hoạt động</span>
                                        @endif
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Mô tả ngắn:</strong> {{ $product->short_description }}
                                    </p>
                                    <p class="card-text fs-5">
                                        <strong>Mô tả dài:</strong> {{ $product->long_description }}
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-primary">
                                            <i class="bi bi-pencil-square"></i> Chỉnh sửa
                                        </a>
                                        <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left-circle"></i> Quay về danh sách
                                        </a>
                                      
                                    </div>
                                </div>
                                <!-- Actions -->
                               
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information (Optional) -->
                {{-- <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Thông tin bổ sung</h5>
                                <p class="card-text">Bạn có thể thêm nội dung bổ sung ở đây, ví dụ như số lượng tồn kho,
                                    ngày thêm sản phẩm, hoặc đánh giá của người dùng.</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

    </main>
@endsection
@section('js')
@endsection
