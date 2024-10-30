@extends('layouts.admin')
@section('title')
@endsection
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

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
                <div>
                    <h2>Tìm kiếm</h2>
                    <form action="">
                        <div class="row">
                            <div class="col-3">
                                <label class="form-label">Tên</label>
                                <input type="text" name="name" placeholder="Nhập tên" class="form-control">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Sắp xếp</label>
                                <select name="order_with" id="" class="form-control">
                                    <option selected value="">--Sắp xếp theo--</option>
                                    <option value="date_asc">Ngày tạo tăng dần</option>
                                    <option value="date_desc">Ngày tạo giảm dần</option>
                                    <option value="price_asc">Giá tăng dần</option>
                                    <option value="price_desc">Giá giảm dần</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Trạng thái</label>
                                <select name="active" class="form-control">
                                    <option value="hot">Sản phẩm nổi bật</option>
                                    <option value="no_hot">Sản phẩm không nổi bật</option>
                                    <option value="active">Sản phẩm hiển thị</option>
                                    <option value="no_active">Sản phẩm không hiển thị</option>
                                </select>
                            </div>
                            <div class="col-2"> 
                                <label class="form-label">Danh mục</label>
                                <select name="categories[]" id="categories" multiple>
                                    <option value="1">abc</option>
                                    <option value="2">van</option>
                                    <option value="3">vanmongmo</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                                <button class="btn btn-danger" type="reset">Xóa trống</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="row">
                    <div class="col-2">
                        <a href="{{ route('admin.product.create') }}"><button class="btn btn-success">Thêm mới</button></a>
                    </div>
                </div>

            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Giá khuyến mãi</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Nổi bật</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thứ tự</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td><img src="{{ asset($product->image) }}" alt="" height="100px" width="100px"></td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->sale }}</td>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach ($product->ProductCategories as $item)
                                        <li>{{ $item->category->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <button
                                    class="toggle-hot-btn btn btn-xs btn-success {{ $product->best == 1 ? 'btn-success' : 'btn-danger' }} text-white "
                                    data-id="{{ $product->id }}" data-status="{{ $product->best }}"
                                    data-url="{{ route('admin.product.changeBest') }}">

                                    {{ $product->best == 1 ? 'Nổi bật' : 'Không' }}

                                </button>
                            </td>
                            <td>
                                <button
                                    class="toggle-active-btn btn btn-xs btn-success {{ $product->active == 1 ? 'btn-success' : 'btn-danger' }} text-white "
                                    data-id="{{ $product->id }}" data-status="{{ $product->active }} "
                                    data-url="{{ route('admin.product.changeActive') }}">

                                    {{ $product->active == 1 ? 'Hiển thị' : 'Ẩn' }}

                                </button>
                            </td>

                            <td>
                                <input type="number" min="1" name="order" class="form-control changeOrder"
                                    style="width: 67px" data-id="{{ $product->id }}"
                                    data-url="{{ route('admin.product.changeOrder') }}" value="{{ $product->order }}">
                            </td>


                            <td>
                                <button type="button" class="btn btn-primary btn-sm">Sửa</button>
                                <button type="button" class="btn btn-danger btn-sm">Xóa</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="d-flex justify-content-center align-items-center p-5">
                {{ $products->links('pagination::bootstrap-4') }}</div>
        </div>
        </div> <!--end::Container-->
        </div> <!--end::App Content-->
    </main>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/admin/change.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></>
    <script>
        $(document).ready(function() {
            $('#categories').select2({
                placeholder: "Chọn danh mục",
                allowClear: true
            });
        });
    </script>
@endsection
