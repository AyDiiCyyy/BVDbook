@extends('layouts.admin')
@section('title')
    {{$title}}
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
                        <h3 class="mb-0">{{$title}}</h3>
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
                <div class="row">
                    <div class="col-2">
                        <a href="{{ route('admin.category.create') }}"><button class="btn btn-success">Thêm mới</button></a>
                    </div>
                    <div class="col-10 d-flex justify-content-end align-items-center">
                        <div class="form-group d-flex">
                            <form action="{{ route('admin.category.index') }}" method="GET" class="row">
                                <div class="col-4">
                                    <input type="text" name="name" class="form-control" placeholder="Tìm kiếm theo tên" value="{{ request('name') }}">
                                </div>
                                {{-- <div class="col-4">
                                    <select name="parent_id" class="form-control">
                                        <option value="" selected>--Danh mục cha--</option>
                                        @foreach($allCategories as $cat)
                                            <option value="{{ $cat->id }}" {{ request('parent_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                </div>
                        </div>
                    </div>
                </div>
                @if (session('status_succeed'))
    <div class="alert alert-success">
        {{ session('status_succeed') }}
    </div>
@endif

@if (session('status_failed'))
    <div class="alert alert-danger">
        {{ session('status_failed') }}
    </div>
@endif
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Đường Dẫn</th>
                            <th scope="col"></th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" height="100px" width="100px">
                                    @else
                                        <img src="https://via.placeholder.com/100" alt="No Image" height="100px" width="100px">
                                    @endif
                                </td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    {{-- {{ $category->parent ? $category->parent->name : 'Danh mục chính' }} --}}
                                </td>

                                <td>
                                    <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                                    <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>                    
                </table>

            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
@section('js')

@endsection
