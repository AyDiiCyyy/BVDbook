@extends('layouts.admin')
@section('title')
@endsection
@section('css')
<style>
    .slide-image {
        width: 180px; /* Larger width for prominence */
        height: 120px; /* Larger height for prominence */
        object-fit: cover; /* Maintain aspect ratio and fill the space */
        border-radius: 10px; /* Rounded corners for a modern look */
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2); /* Stronger shadow for emphasis */
        border: 2px solid #007bff; /* Add a border to draw attention */
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth effects on hover */
    }

    .slide-image:hover {
        transform: scale(1.1); /* More prominent zoom effect */
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3); /* Enhance shadow on hover */
        border-color: #28a745; /* Change border color to highlight on hover */
    }

    td img {
        display: block;
        margin: 0 auto; /* Center the image in the table cell */
    }
</style>

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
                {{-- <div class="container mt-2 mb-4">
                    <h3 class="mb-4">Tìm kiếm</h3>
                    <form action="{{ route('admin.product.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="form-label">Tên</label>
                                <input type="text" name="name" placeholder="Nhập tên" class="form-control"
                                    value="{{ $request->name ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Sắp xếp</label>
                                <select name="order_with" class="form-select">
                                    <option selected value="">--Sắp xếp theo--</option>
                                    <option value="date_asc" @selected($request->order_with == 'date_asc')>Ngày tạo tăng dần</option>
                                    <option value="date_desc" @selected($request->order_with == 'date_desc')>Ngày tạo giảm dần</option>
                                    <option value="price_asc" @selected($request->order_with == 'price_asc')>Giá tăng dần</option>
                                    <option value="price_desc" @selected($request->order_with == 'price_desc')>Giá giảm dần</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Trạng thái</label>
                                <select name="active" class="form-select">
                                    <option selected value="">--Lọc--</option>
                                    <option value="hot" @selected($request->active == 'hot')>Sản phẩm nổi bật</option>
                                    <option value="no_hot" @selected($request->active == 'no_hot')>Sản phẩm không nổi bật</option>
                                    <option value="active" @selected($request->active == 'active')>Sản phẩm hiển thị</option>
<option value="no_active" @selected($request->active == 'no_active')>Sản phẩm không hiển thị</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Danh mục</label>
                                <select class="form-select" name="categories[]" id="categories" multiple>
                                    @foreach ($listCategory as $category)
                                        <option value="{{ $category->id }}" @selected(in_array($category->id, $request->categories ?? []))>
                                            {{ $category->name }}</option>
                                        @if (count($category->childrenRecursive) > 0)
                                            @include('admin.components.child-category', [
                                                'children' => $category->childrenRecursive,
                                                'depth' => 1,
                                                'cateData' => $request->categories,
                                            ])
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-start justify-content-center mt-5">
                                <button class="btn btn-primary me-2" type="submit">Tìm kiếm</button>
                                <button class="btn btn-danger" type="reset">Xóa trống</button>
                            </div>


                        </div>
                    </form>
                </div> --}}
                <div class="row">
                    <div class="col-2">
                        <a href="{{ route('admin.slide.create') }}"><button class="btn btn-success">Thêm mới</button></a>
                    </div>
                </div>

            </div>
            <table class="table table-striped">
                <thead class="text-center align-middle">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thứ tự</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody class="text-center align-middle">
                    @foreach ($slides as $key => $slide)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $slide->name }}</td>
                            <td><img src="{{ asset($slide->image) }}" alt="Slide Image" class="slide-image">
                            </td>
                            <td>
                                <button
                                    class="toggle-active-btn btn btn-xs btn-success {{ $slide->active == 1 ? 'btn-success' : 'btn-danger' }} text-white "
                                    data-id="{{ $slide->id }}" data-status="{{ $slide->active }} "
                                    data-url="{{ route('admin.slide.changeActive') }}">

                                    {{ $slide->active == 1 ? 'Hiển thị' : 'Ẩn' }}

                                </button>
                            </td>

                            <td class="text-center align-middle">
                                <input type="number" min="1" name="order" class="form-control changeOrder mx-auto text-center"
                                    style="width: 70px" data-id="{{ $slide->id }}"
                                    data-url="{{ route('admin.slide.changeOrder') }}" value="{{ $slide->order }}">
                            </td>


                            <td class="text-center align-middle">
                                <a href="{{ route('admin.slide.edit', $slide->id) }}" class="btn btn-primary">Sửa</a>

                            </td>


                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="d-flex justify-content-center align-items-center p-5">
                {{ $slides->links('pagination::bootstrap-4') }}</div>
            </div>
        </div> <!--end::Container-->
        </div> <!--end::App Content-->
    </main>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/admin/change.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categories').select2({
                placeholder: "Chọn danh mục",
                allowClear: true
            });
        });
    </script>
@endsection
