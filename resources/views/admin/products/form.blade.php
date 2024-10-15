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
        <div class="app-content"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row g-4"> <!--begin::Col-->
                    <div class="col-md-6">
                        <div class="card card-primary card-outline mb-4"> <!--begin::Header-->
                            <form> <!--begin::Body-->
                                <div class="card-body">
                                    <div class="mb-3"> <label class="form-label">Tên sản
                                            phẩm</label>
                                        <input type="text" class="form-control" name="name">

                                    </div>
                                    <div class="mb-3"> <label class="form-label">Giá sản
                                            phẩm</label>
                                        <input type="number" class="form-control" name="price">

                                    </div>
                                    <div class="mb-3"> <label class="form-label">Giảm giá</label>
                                        <input type="number" class="form-control" name="sale">

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mô tả
                                            ngắn</label>
                                        <input type="text" class="form-control" name="short_description">

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mô tả
                                            dài</label>
                                        <br>
                                        <textarea name="" id="" cols="" rows="" name="long_description"></textarea>

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

                                </div> <!--end::Body--> <!--begin::Footer-->
                                {{-- <div class="card-footer"> <button type="submit" class="btn btn-primary">Submit</button>
                                </div> <!--end::Footer--> --}}
                            </form> <!--end::Form-->
                        </div> <!--end::Quick Example--> <!--begin::Input Group-->
                    </div>
                    {{-- right --}}
                    <div class="col-md-6">
                        <div class="card card-primary card-outline mb-4"> <!--begin::Header-->
                            <form> <!--begin::Body-->
                                <div class="card-body">
                                    <div class="mb-3"> <label class="form-label">Năm xuất bản</label>
                                        <input type="number" class="form-control" name="released">

                                    </div>
                                    <div class="mb-3"> <label class="form-label">Cân nặng</label>
                                        <input type="text" class="form-control" name="weight">

                                    </div>
                                    <div class="mb-3"> <label class="form-label">Số trang</label>
                                        <input type="number" class="form-control" name="page">

                                    </div>
                                    <div class="mb-3"> <label class="form-label">Số lượng</label>
                                        <input type="number" class="form-control" name="quantity">

                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label">Danh mục</label>
                                        <select class="form-control" name="categories" id="">
                                            <option value="">danh mục 1</option>
                                            <option value="">danh mục 2</option>
                                        </select>

                                    </div>
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Ảnh sản phẩm</label>
                                        <input type="file" class="form-control" name="publisher">

                                    </div>
                                    <div class="mb-3 d-flex justify-content-center mt-5">
                                        <button class="btn btn-primary">Thêm mới</button>
                                    </div>


                                </div> <!--end::Body--> <!--begin::Footer-->
                                {{-- <div class="card-footer"> <button type="submit" class="btn btn-primary">Submit</button>
            </div> <!--end::Footer--> --}}
                            </form> <!--end::Form-->
                        </div> <!--end::Quick Example--> <!--begin::Input Group-->
                    </div>
                </div> <!--end::Row-->
            </div> <!--end::Container-->
        </div> <!--end::App Content-->
    </main> <!--end::App Main--> <!--begin::Footer-->
@endsection
@section('js')
@endsection
