@extends('client.layouts')

@section('title')
    Trang Tài Khoản
@endsection

@section('content')
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-hrading">Trang Tài Khoản</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="index.html">Trang Chủ</a></li>
                            <li>Tài Khoản Của Tôi</li>
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
                    <div id="profile" class="collapse show">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Thông Tin Hồ Sơ</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/img/avatar.png') }}"
                                            alt="Avatar" class="img-fluid"
                                            style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-8">
                                        <p><strong>Tên:</strong> {{ Auth::user()->name }}</p>
                                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                        <p><strong>Địa Chỉ:</strong> {{ Auth::user()->address }}</p>
                                        <p><strong>Số điện thoại:</strong> {{ Auth::user()->phone }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Thông Tin Đơn Hàng và Voucher </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative"
                                            style="width: 120px; height: 120px; background-image: url('{{ asset('assets/img/donhang.jfif') }}'); background-size: cover; background-position: center; border-radius: 10px;">
                                            <div class="position-absolute top-0 end-0 p-2"
                                                style="right: 5px; top: 5px; background-color: rgba(0, 123, 255, 0.7); border-radius: 20%;">
                                                <p class="text-white fs-4 mb-0">{{ $orderCount }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('client.account.orders') }}" class="btn btn-primary mt-2">Xem Chi Tiết Đơn Hàng</a>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative"
                                            style="width: 120px; height: 120px; background-image: url('{{ asset('assets/img/voucher.png') }}'); background-size: cover; background-position: center; border-radius: 10px;">
                                            <div class="position-absolute top-0 end-0 p-2"
                                                style="right: 5px; top: 5px; background-color: rgba(0, 123, 255, 0.7); border-radius: 20%;">
                                                <p class="text-white fs-4 mb-0">4</p>
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-primary mt-2">Xem Các Voucher</a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
