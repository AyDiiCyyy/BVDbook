@extends('client.layouts')

@section('title', 'Đổi Mật Khẩu')

@section('content')
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-heading">Đổi Mật Khẩu</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="#">Trang Chủ</a></li>
                            <li>Đổi Mật Khẩu</li>
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
                        <a href="{{ route('voucher') }}" class="list-group-item list-group-item-action">Voucher</a>
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
                            <h5>Đổi Mật Khẩu</h5>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <form action="{{ route('client.account.update-password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="current-password" class="form-label">Mật Khẩu Hiện Tại</label>
                                    <input type="password" class="form-control" id="current-password"
                                        name="current_password" required>
                                    @error('current_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="new-password" class="form-label">Mật Khẩu Mới</label>
                                    <input type="password" class="form-control" id="new-password" name="password" required>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="confirm-password" class="form-label">Xác Nhận Mật Khẩu Mới</label>
                                    <input type="password" class="form-control" id="confirm-password"
                                        name="password_confirmation" required>
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Cập Nhật Mật Khẩu</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
