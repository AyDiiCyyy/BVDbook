@extends('layouts.admin')
@section('title')
@endsection
@section('css')
@endsection
@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Thêm mới</h3>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->

        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline mb-4">
                            <!-- Form bắt đầu từ đây -->
                            <form>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Cột trái -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tên sản phẩm</label>
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Giá sản phẩm</label>
                                                <input type="number" class="form-control" name="price">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Giảm giá</label>
                                                <input type="number" class="form-control" name="sale">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Mô tả ngắn</label>
                                                <input type="text" class="form-control" name="short_description">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Mô tả dài</label>
                                                <textarea name="long_description" class="form-control" rows="4"></textarea>
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

                                        <!-- Cột phải -->
                                        <div class="col-md-6">
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
                                                <label class="form-label">Danh mục</label>
                                                <select class="form-control" name="categories">
                                                    <option value="1">Danh mục 1</option>
                                                    <option value="2">Danh mục 2</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Ảnh sản phẩm</label>
                                                <input type="file" class="form-control" name="image_product">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nút submit nằm giữa hai cột -->
                                    <div class="mb-3 d-flex justify-content-center mt-5">
                                        <button class="btn btn-primary">Thêm mới</button>
                                    </div>
                                </div>
                            </form>
                            <!-- Form kết thúc ở đây -->
                        </div>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
@section('js')
@endsection
