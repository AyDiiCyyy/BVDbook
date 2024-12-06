@extends('client.layouts')

@section('title', 'Cập Nhật Thông Tin Tài Khoản')

@section('content')
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-heading">Cập Nhật Thông Tin Tài Khoản</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="#">Trang Chủ</a></li>
                            <li>Cập Nhật Thông Tin</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="account-area mtb-60px">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="list-group">
                        <a href="{{ route('my-account') }}" class="list-group-item list-group-item-action">Hồ Sơ</a>
                        <a href="{{ route('client.account.update-profile') }}" class="list-group-item list-group-item-action">Thông Tin</a>
                        <a href="{{ route('client.account.orders') }}" class="list-group-item list-group-item-action">Đơn Hàng</a>
                        <a href="#" class="list-group-item list-group-item-action">Voucher</a>
                        <a href="{{ route('client.account.change-password.form') }}"class="list-group-item list-group-item-action">Đổi Mật Khẩu</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a href="#" class="btn btn-danger mt-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng Xuất</a>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h5>Cập Nhật Thông Tin </h5>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <form action="{{ route('client.account.update-profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa Chỉ</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số Điện Thoại</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Avatar</label>
                                    <input type="file" class="form-control" id="avatar" name="avatar">
                                    @error('avatar')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @if ($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="mt-2" width="100px">
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Cập Nhật Thông Tin</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
