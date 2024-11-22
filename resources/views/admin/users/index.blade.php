@extends('layouts.admin')
@section('title')
    {{-- {{$title}} --}}
@endsection
@section('css')
<style>
    .avatar-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
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
                    {{-- <a href="{{ route('admin.user.create') }}">
                        <button class="btn btn-success">Thêm mới</button>
                    </a> --}}
                </div>
                <div class="col-10 d-flex justify-content-end align-items-center">
                    <div class="form-group d-flex search-form">
                        <form action="{{ route('admin.user.index') }}" method="GET" class="row w-100">
                            <div class="col-7">
                                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên" value="{{ request('search') }}">
                            </div>
                            <div class="col-5">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

       

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Tên người dùng</th>
                        <th scope="col">Email</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col" class="avatar-column"> Ảnh đại diện</th>
                        <th scope="col">Vai trò</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                @if ($user->avatar)
                                {{-- lấy ảnh từ storage --}}
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="avatar-circle">
                                    
                                {{-- ảnh mẫu fake data --}}
                                {{-- <img src="{{ asset('assets/img/user2-160x160.jpg') }}" alt="User  Image" class="avatar-circle"> --}}
                                @else
                                    <img src="{{ asset('assets/img/user2-160x160.jpg') }}" alt="User  Image" class="avatar-circle">
                                @endif
                            </td>
                            <td>{{ $user->role == 1 ? 'Người dùng' : 'Admin' }}</td>
                            <td>
                                <select class="form-control status-select" data-id="{{ $user->id }}">
                                    <option value="1" {{ $user->active == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="2" {{ $user->active == 2 ? 'selected' : '' }}>Tài khoản bị khóa</option>
                                    <option value="0" {{ $user->active == 0 ? 'selected' : '' }}>Chưa kích hoạt</option>
                                </select>
                            </td>
                            <td class="alg">
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary w-50">Sửa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
 </table>

            <!-- Phân trang -->
        
            <div class="d-flex justify-content-center align-items-center p-5">
                {{ $users->links('pagination::bootstrap-4') }}</div>
        </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var changeActiveUrl = "{{ route('admin.user.changeActive') }}";
    </script>
    <script src="{{ asset('js/admin/userActive.js') }}"></script>
@endsection