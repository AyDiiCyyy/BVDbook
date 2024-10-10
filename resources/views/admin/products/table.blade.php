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
                        <h3 class="mb-0">Table</h3>
                    </div>

                </div> <!--end::Row-->
            </div> <!--end::Container-->
        </div> <!--end::App Content Header--> <!--begin::App Content-->
        <div class="app-content"> <!--begin::Container-->

            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-2">
                        <button class="btn btn-success">Thêm mới</button>
                    </div>
                    <div class="col-10 d-flex justify-content-end align-items-center">
                        <div class="form-group d-flex">
                            <input type="text" class="form-control me-2 w-auto" placeholder="Tìm kiếm">
                            <select name="search" id="" class="form-control me-2 w-auto">
                                <option value="">--Danh mục--</option>
                                <option value="1">danh mục 1</option>
                                <option value="2">danh mục 2</option>
                            </select>
                            <button class="btn btn-primary">Tìm kiếm</button>
                        </div>
                    </div>
                </div>

            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Giá khuyến mãi</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Nổi bật</th>
                        <th scope="col">Thứ tự</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sản phẩm 1</td>
                        <td><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTa7TeV6e3pSGltDK7YgIBy7iKWET4qL0KRgw&s"
                                alt="" srcset="" height="100px" width="100px"></td>
                        <td>100d</td>
                        <td>99d</td>
                        <td>danh mục 1</td>
                        <td>
                            <button class="toggle-hot-btn btn btn-xs btn-success " data-id="" data-status=""
                                data-url="">
                                {{-- btn-success 
          bt-danger --}}
                                Nổi bật
                                {{-- Không --}}
                            </button>
                        </td>
                        <td>
                            <input class="form-control" type="number" name="order" min="0" id=""
                                style="width:50px">
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm">Sửa</button>
                            <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> <!--end::Container-->
        </div> <!--end::App Content-->
    </main>
@endsection
@section('js')
@endsection
