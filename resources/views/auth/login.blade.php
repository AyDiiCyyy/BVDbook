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
                                <h4>Đăng nhập</h4>
                            </a>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="email">{{ __('Email') }}</label>
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="password">{{ __('Mật khẩu') }}</label>
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="current-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-check mb-3">
                                                <input type="checkbox" id="remember" name="remember"
                                                    {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="remember">{{ __('Ghi nhớ đăng nhập') }}</label>
                                            </div>

                                            <div class="button-box">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ __('Đăng nhập') }}</button>
                                                @if (Route::has('password.request'))
                                                    <a class="btn btn-link"
                                                        href="{{ route('password.request') }}">{{ __('Quên mật khẩu') }}</a>
                                                @endif
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
