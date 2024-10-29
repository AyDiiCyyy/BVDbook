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
                        <a href="{{route('admin.product.create')}}"><button class="btn btn-success">Thêm mới</button></a>
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
                            <td><img src="{{asset($product->image)}}" alt=""
                                    height="100px" width="100px"></td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->sale }}</td>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach ($product->ProductCategories as $item   )
                                        <li>{{$item->category->name}}</li>
                                    
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
                               <input type="number" min="1" name="order" class="form-control changeOrder" style="width: 67px"
                               data-id="{{$product->id}}" data-url="{{route('admin.product.changeOrder')}}" value="{{$product->order}}">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('js/admin/change.js')}}"></script>
    
@endsection
