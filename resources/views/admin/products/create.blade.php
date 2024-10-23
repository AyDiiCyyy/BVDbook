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
                        <h3 class="mb-0">Thêm mới</h3>
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
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row g-4">
                    <!--begin::Col-->
                    <div class="col-md-12"> <!-- Sử dụng col-md-12 để chiếm toàn bộ chiều rộng -->
                        <div class="card card-primary card-outline mb-4">
                            <!--begin::Header-->
                            <form method="post" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                                <!-- Chỉ cần một thẻ form duy nhất -->
                                @csrf
                                <div class="card-body row"> <!-- Sử dụng class row để tạo cấu trúc hai cột -->
                                    <!-- Cột bên trái -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tên sản phẩm</label>
                                            <input type="text" class="form-control" name="name">
                                            @error('name')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Slug sản phẩm</label>
                                            <input type="text" class="form-control" name="slug">
                                            @error('slug')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Giá sản phẩm</label>
                                            <input type="number" class="form-control" name="price">
                                            @error('price')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Giảm giá</label>
                                            <input type="number" class="form-control" name="sale">
                                            @error('sale')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mô tả ngắn</label>
                                            <input type="text" class="form-control" name="short_description">
                                        </div>
                                        @error('short_description')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="mb-3">
                                            <label class="form-label">Mô tả dài</label>
                                            <textarea class="form-control" name="long_description" cols="" rows=""></textarea>
                                        </div>
                                        @error('long_description')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="mb-3">
                                            <label class="form-label">Tác giả</label>
                                            <input type="text" class="form-control" name="author">
                                        </div>
                                        @error('author')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="mb-3">
                                            <label class="form-label">Nhà xuất bản</label>
                                            <input type="text" class="form-control" name="publisher">
                                        </div>
                                        @error('publisher')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Cột bên phải -->
                                    <div class="col-md-6">

                                        <div class="mb-3">
                                            <label class="form-label">Ảnh đại diện</label>
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                        @error('image')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="mb-3">
                                            <label class="form-label">Năm xuất bản</label>
                                            <input type="number" class="form-control" name="released">
                                        </div>
                                        @error('released')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="mb-3">
                                            <label class="form-label">Cân nặng</label>
                                            <input type="text" class="form-control" name="weight">
                                        </div>
                                        @error('weight')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="mb-3">
                                            <label class="form-label">Số trang</label>
                                            <input type="number" class="form-control" name="page">
                                        </div>
                                         @error('page')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="mb-3">
                                            <label class="form-label">Số lượng</label>
                                            <input type="number" class="form-control" name="quantity">
                                        </div>
                                        @error('page')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="mb-3">
                                            <label class="form-label">Danh mục</label>
                                            <select class="form-control" name="categories[]" multiple>
                                                <option value="">danh mục 1</option>
                                                <option value="">danh mục 2</option>
                                            </select>
                                        </div>
                                        @error('categories')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="mb-3">
                                            <label class="form-label">Ảnh sản phẩm</label>
                                            <input type="file" class="form-control" name="product_image">
                                        </div>
                                        @error('product_image')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> <!--end::Body-->

                                <!-- Nút gửi -->
                                <div class="mb-3 d-flex justify-content-center mt-5">
                                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                                </div>
                            </form> <!--end::Form-->
                        </div> <!--end::Quick Example-->
                    </div>
                </div> <!--end::Row-->
            </div> <!--end::Container-->
        </div> <!--end::App Content-->
    </main>
@endsection
@section('js')
@endsection
