@extends('layouts.admin')
@section('title')
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
                <div class="row g-4">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline mb-4">
                            <form method="POST" action="{{ route('admin.slide.update', $slide->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Tên slide: </label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', $slide->name) }}">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Ảnh slide: </label>
                                        <input type="file" class="form-control" name="image">
                                        <img src="{{ asset($slide->image) }}" alt="Ảnh slide" class="img-thumbnail rounded shadow" style="width: 800px; height: auto; object-fit: cover;">
                                        @error('image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Số thứ tự</label>
                                        <input type="number" class="form-control" name="order"
                                            value="{{ old('order', $slide->order) }}" min="1">
                                        @error('order')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3 form-check">
                                            <label class="form-check-label">Trạng thái</label>
                                            <input type="checkbox" class="form-check-input" name="active" value="1"
                                            @checked($slide->active ?? false)>
                                            @error('active')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Sửa</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('js')
@endsection
