@extends('layouts.admin')
@section('title')
@endsection
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        textarea.auto-resize {
            resize: none;
            /* Vô hiệu hóa khả năng thay đổi kích thước thủ công */
            transition: height 0.2s ease;
            /* Hiệu ứng mượt khi thay đổi chiều cao */
            overflow: hidden;
            /* Ẩn thanh cuộn dọc */
        }
    </style>

    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-file-upload/10.23.0/css/jquery.fileupload.css" rel="stylesheet" /> --}}
@endsection
@section('content')
    <main class="app-main"> <!--begin::App Content Header-->
        <div class="app-content-header"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Cập nhật</h3>
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
                            <form method="post" action="{{ route('admin.product.update', $product->id) }}"
                                enctype="multipart/form-data">
                                <!-- Chỉ cần một thẻ form duy nhất -->
                                @csrf
                                <div class="card-body row"> <!-- Sử dụng class row để tạo cấu trúc hai cột -->
                                    <!-- Cột bên trái -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tên sản phẩm</label>
                                            <input type="text" class="form-control" name="name" id="slug"
                                                value="{{ old('name', $product->name) }}" onkeyup="ChangeToSlug()">
                                            @error('name')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Đường dẫn</label>
                                            <input type="text" class="form-control" name="slug" id="convert_slug"
                                                value="{{ old('slug', $product->slug) }}">
                                            @error('slug')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mã sản phẩm</label>
                                            <input type="text" class="form-control" name="sku"
                                                value="{{ old('sku', $product->sku) }}">
                                            @error('sku')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Giá sản phẩm</label>
                                            <input type="number" class="form-control" name="price"
                                                value="{{ old('price', number_format($product->price, 0, '', '')) }}">
                                            @error('price')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Giảm giá</label>
                                            <input type="number" class="form-control" name="sale"
                                                value="{{ old('sale', number_format($product->sale, 0, '', '')) }}">
                                            @error('sale')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mô tả ngắn</label>
                                            <input type="text" class="form-control" name="short_description"
                                                value="{{ old('short_description', $product->short_description) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mô tả dài</label>
                                            <textarea class="form-control auto-resize" name="long_description" rows="3" style="overflow:hidden;">{{ old('long_description', $product->long_description) }}</textarea>
                                        </div>


                                        <div class="mb-4">
                                            <label class="form-label">Ảnh đại diện</label>
                                            <input type="file" class="form-control" name="image">
                                            <img src="{{ asset($product->image) }}" alt="" width="200">
                                            @error('image')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="mb-3 form-check">
                                                    <label class="form-check-label">Sản phẩm nổi bật</label>
                                                    <input type="checkbox" class="form-check-input" name="best"
                                                        value="1" @checked($product->best ?? false)>
                                                    @error('best')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3 form-check">
                                                    <label class="form-check-label">Trạng thái</label>
                                                    <input type="checkbox" class="form-check-input" name="active"
                                                        value="1" @checked($product->active ?? false)>
                                                    @error('active')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Cột bên phải -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Danh mục</label>
                                            <select class="form-control" name="categories[]" id="categories" multiple>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @selected(in_array($category->id, old('categories', $selectedCategories)))>
                                                        {{ $category->name }}
                                                    </option>
                                                    @if (count($category->childrenRecursive) > 0)
                                                        @include('admin.components.child-category', [
                                                            'children' => $category->childrenRecursive,
                                                            'depth' => 1,
                                                            'cateData' => $selectedCategories,
                                                        ])
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('categories')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tác giả</label>
                                            <input type="text" class="form-control" name="author"
                                                value="{{ old('author', $product->author) }}">
                                            @error('author')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nhà xuất bản</label>
                                            <input type="text" class="form-control" name="publisher"
                                                value="{{ old('publisher', $product->publisher) }}">
                                            @error('publisher')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Năm xuất bản</label>
                                            <input type="number" class="form-control" name="released"
                                                value="{{ old('released', $product->released) }}">
                                            @error('released')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Cân nặng</label>
                                            <input type="number" class="form-control" name="weight"
                                                value="{{ old('weight', $product->weight) }}">
                                            @error('weight')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Số trang</label>
                                            <input type="number" class="form-control" name="page"
                                                value="{{ old('page', $product->page) }}">
                                            @error('page')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Số lượng</label>
                                            <input type="number" class="form-control" name="quantity"
                                                value="{{ old('quantity', $product->quantity) }}">
                                            @error('quantity')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Số thứ tự</label>
                                            <input type="number" class="form-control" name="order"
                                                value="{{ old('order', $product->order) }}" min="1">
                                            @error('order')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="fileupload">Ảnh liên quan</label>
                                            <input type="file" class="form-control" id="fileupload"
                                                name="product_image[]"id="fileupload" multiple>
                                            @foreach ($product->galleries as $product_image)
                                                <img class="mx-2 " src="{{ $product_image->image }}" alt=""
                                                    width="100">
                                            @endforeach
                                        </div>
                                        @error('product_image')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @foreach ($errors->get('product_image.*') as $messages)
                                            @foreach ($messages as $message)
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div> <!--end::Body-->

                                <!-- Nút gửi -->
                                <div class="mb-3 d-flex justify-content-center mt-5">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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
    <script>
        $(document).ready(function() {
            $('#categories').select2({
                placeholder: "Chọn danh mục",
                allowClear: true
            });
        });
    </script>


    <script>
        function ChangeToSlug() {
            var slug;

            //Lấy text từ thẻ input title 
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            // alert(slug);
            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            document.getElementById('convert_slug').value = slug;
        }
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const textareas = document.querySelectorAll('.auto-resize');

        textareas.forEach(textarea => {
            // Hàm tự động thay đổi chiều cao
            const autoResize = () => {
                textarea.style.height = 'auto'; // Đặt chiều cao về auto trước
                textarea.style.height = textarea.scrollHeight + 'px'; // Thay đổi chiều cao theo nội dung
            };

            // Gọi hàm khi nội dung thay đổi
            textarea.addEventListener('input', autoResize);

            // Gọi hàm một lần khi tải trang nếu có nội dung sẵn
            autoResize();
        });
    });
</script>
@endsection
