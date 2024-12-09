@extends('layouts.admin')

@section('title')
    {{ $title }}
@endsection

@section('css')
@endsection

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">{{ $title }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-2">
                        <a href="{{ route('admin.category.create') }}">
                            <button class="btn btn-success">Thêm mới</button>
                        </a>
                    </div>

                    <div class="col-10 d-flex justify-content-end">
                        <form action="{{ route('admin.category.index') }}" method="GET"
                            class="d-flex align-items-center w-75">
                            <div class="input-group mr-2 w-75">
                                <input type="text" name="name" class="form-control" placeholder="Tìm kiếm theo tên"
                                    value="{{ request('name') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="text-center align-middle">
                            <tr>
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Đường Dẫn</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-center align-middle">
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                alt="{{ $category->name }}" class="img-fluid" style="max-height: 100px;">
                                        @else
                                            <img src="https://via.placeholder.com/100" alt="No Image" class="img-fluid"
                                                style="max-height: 100px;">
                                        @endif
                                    </td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        <button
                                            class="toggle-active-btn btn btn-xs btn-success {{ $category->status == 1 ? 'btn-success' : 'btn-danger' }} text-white "
                                            data-id="{{ $category->id }}" data-status="{{ $category->status }} "
                                            data-url="{{ route('admin.category.changeActive') }}">
        
                                            {{ $category->status == 1 ? 'Hiển thị' : 'Ẩn' }}
        
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.category.edit', $category->id) }}"
                                            class="btn btn-success btn-sm">Sửa</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/admin/change.js') }}"></script>
@endsection
