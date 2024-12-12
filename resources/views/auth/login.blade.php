@extends('layouts.auth')

@section('content')
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <div id="preloader" class="preloader">
        <div class='inner'>
            <div class='line1'></div>
            <div class='line2'></div>
            <div class='line3'></div>
        </div>
    </div>
	<div id="wrapper" class="wrapper">
		<div class="fxt-template-animation fxt-template-layout5">
			<div class="fxt-bg-img fxt-none-767" data-bg-image="{{asset('assets/login/img/figure/bg5-l.jpg')}}">
				<div class="fxt-intro">
					<div class="sub-title">Chào mừng bạn đến với</div>
					<h1>BVD Book</h1>
					<p>Website bán sách uy tín số 1 Việt Nam .</p>
				</div>
			</div>
			<div class="fxt-bg-color">
				<div class="fxt-header">
					<a href="{{route('index')}}" class="fxt-logo"><img src="{{asset('assets/login/img/logo.jpg')}}" width="300px" alt="Logo')}}" ></a>
					<div class="fxt-page-switcher">
						<a href="{{ route('login') }}" class="switcher-text switcher-text1 active">Đăng nhập</a>
						<a href="{{ route('register') }}" class="switcher-text switcher-text2">Đăng ký</a>
					</div>
				</div>
                <div class="fxt-form">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group fxt-transformY-50 fxt-transition-delay-1">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>
                            <i class="flaticon-envelope"></i>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group fxt-transformY-50 fxt-transition-delay-2">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Mật khẩu" required autocomplete="current-password">
                            <i class="flaticon-padlock"></i>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <a href="{{ route('password.request') }}" class="switcher-text3">Quên mật khẩu</a>
                        </div>
                        <div class="form-group fxt-transformY-50 fxt-transition-delay-3">
                            <div class="fxt-content-between">
                                <button type="submit" class="fxt-btn-fill">Đăng nhập</button>
                                <div class="checkbox">
                                    <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">Ghi nhớ đăng nhập</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
		
			</div>
		</div>
	</div>
@endsection
