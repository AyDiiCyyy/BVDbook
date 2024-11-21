@extends('layouts.auth')

@section('content')
    <section class="breadcrumb-area" style="margin-top: -30px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-hrading">
                            <a href="{{ route('login') }}" style="text-decoration: none; color: inherit;">Đăng Nhập</a> /
                            <a href="{{ route('register') }}" style="text-decoration: none; color: inherit;">Đăng Ký</a>
                        </h1>
                        <ul class="breadcrumb-links">
                            <li><a href="{{ url('/') }}">Trang Chủ</a></li>
                            <li>Đăng nhập / Đăng ký</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="login-register-area mb-60px mt-0px" style="margin-top: -50px">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 mx-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-bs-toggle="tab" href="#lg1">
                                <h4>Đăng Ký</h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                            @csrf

                                            <!-- Name -->
                                            <div class="row mb-3">
                                                <label for="name"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Tên') }}</label>

                                                <div class="col-md-6">
                                                    <input id="name" type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name" value="{{ old('name') }}" required
                                                        autocomplete="name" autofocus>

                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="row mb-3">
                                                <label for="email"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                                <div class="col-md-6">
                                                    <input id="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ old('email') }}" required
                                                        autocomplete="email">

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!--Password -->
                                            <div class="row mb-3">
                                                <label for="password"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Mật Khẩu') }}</label>

                                                <div class="col-md-6">
                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" required autocomplete="new-password">

                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="row mb-3">
                                                <label for="password-confirm"
                                                    class="col-md-4 col-form-label text-md-end">{{ __('Nhập lại mật khẩu') }}</label>

                                                <div class="col-md-6">
                                                    <input id="password-confirm" type="password" class="form-control"
                                                        name="password_confirmation" required autocomplete="new-password">
                                                </div>
                                                
                                            </div>

                                            {{-- <!-- Address -->
                                            <div class="row mb-3">
                                                <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Address') }}</label>
                                        
                                                <div class="col-md-6">
                                                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                                        name="address" value="{{ old('address') }}" autocomplete="address">
                                        
                                                    @error('address')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> --}}

                                            {{-- <!-- Phone -->
                                            <div class="row mb-3">
                                                <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>
                                        
                                                <div class="col-md-6">
                                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                                        name="phone" value="{{ old('phone') }}" autocomplete="phone">
                                        
                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> --}}

                                            {{-- <!-- Avatar -->
                                            <div class="row mb-3">
                                                <label for="avatar" class="col-md-4 col-form-label text-md-end">{{ __('Avatar') }}</label>
                                        
                                                <div class="col-md-6">
                                                    <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror"
                                                        name="avatar" accept="image/*">
                                        
                                                    @error('avatar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> --}}

                                            <!-- Đăng Ký -->
                                            <div class="button-box d-flex justify-content-center">
                                                <button type="submit"
                                                    class="btn btn-primary ">{{ __('Đăng Ký') }}</button>
                                            </div>
                                        </form>
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
