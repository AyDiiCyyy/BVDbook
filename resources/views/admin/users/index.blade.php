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
    .status-select {
        width: 70%;
        min-width: 120px; /* Đặt kích thước tối thiểu */
        padding: 0.25rem 0.5rem; /* Thu nhỏ padding */
        font-size: 0.875rem; /* Thu nhỏ font */
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
                <div class="col-10 d-flex justify-content-end align-items-center mb-4">
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

       

            <table class="table table-striped table-responsive">
                <thead class="text-center align-middle">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên người dùng</th>
                        <th scope="col">Email</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col" class="avatar-column"> Ảnh đại diện</th>
                        <th scope="col">Vai trò</th>
                        <th scope="col">Trạng thái</th>
                        
                    </tr>
                </thead >
                <tbody class="text-center align-middle">
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            @if ($user->phone == null)
                                <td>Tài khoản này chưa cập nhật số điện thoại</td>
                            @else
                            <td>{{ $user->phone }}</td>       
                            @endif
                         
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
                            @if ($user->role == 0)
                            <td class="text-center align-middle" style="width: 16%">
                            Admin không thể thay đổi trạng thái !
                            </td>
                            @else
                                  <td class="text-center align-middle" style="width: 16%">
                                <select class="form-select form-select-sm status-select mx-auto"  data-id="{{ $user->id }}">
                                    <option value="1" {{ $user->active == 1 ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="2" {{ $user->active == 2 ? 'selected' : '' }}>Tài khoản bị khóa</option>
                                </select>
                            </td>
                            @endif
                          
                          
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