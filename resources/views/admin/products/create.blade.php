@extends('layouts.admin')
@section('title')
@endsection
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-file-upload/10.23.0/css/jquery.fileupload.css" rel="stylesheet" /> --}}
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
                                        <div class="mb-3">
                                            <label class="form-label">Mô tả dài</label>
                                            <textarea class="form-control" name="long_description" cols="" rows=""></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tác giả</label>
                                            <input type="text" class="form-control" name="author">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nhà xuất bản</label>
                                            <input type="text" class="form-control" name="publisher">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ảnh đại diện</label>
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>

                                    <!-- Cột bên phải -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Danh mục</label>
                                            <select class="form-control" name="parent_id[]" id="categories" multiple>
                                                <option value="1">danh mục 1</option>
                                                <option value="2">danh mục 2</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Năm xuất bản</label>
                                            <input type="number" class="form-control" name="released">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Cân nặng</label>
                                            <input type="text" class="form-control" name="weight">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Số trang</label>
                                            <input type="number" class="form-control" name="page">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Số lượng</label>
                                            <input type="number" class="form-control" name="quantity">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Ảnh sản phẩm</label>
                                            <input type="file" class="form-control" id="fileupload" name="product_image[]" multiple>
                                        </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> 
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.fileupload/9.22.0/js/jquery.fileupload.min.js"></script> --}}
<script>
    $(document).ready(function() {
        $('#categories').select2({
            placeholder: "Chọn danh mục",
            allowClear: true
        });

        // $('#fileupload').fileupload({
        //     url: '/upload',
        //     dataType: 'json',
        //     done: function(e, data) {
        //         console.log('Tải lên thành công: ' + data.result);
        //     }
        // });
    });

</script>
@endsection
