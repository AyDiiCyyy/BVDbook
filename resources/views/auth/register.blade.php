@extends('layouts.auth')

@section('content')
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
						<a href="{{ route('login') }}" class="switcher-text switcher-text1 ">Đăng nhập</a>
						<a href="{{ route('register') }}" class="switcher-text switcher-text2 active">Đăng ký</a>
					</div>
				</div>
				<div class="fxt-form">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                
                        <!-- Name -->
                        <div class="form-group fxt-transformY-50 fxt-transition-delay-1">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Tên" required autocomplete="name" autofocus>
                            <i class="flaticon-user"></i>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                
                        <!-- Email -->
                        <div class="form-group fxt-transformY-50 fxt-transition-delay-2">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">
                            <i class="flaticon-envelope"></i>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                
                        <!-- Password -->
                        <div class="form-group fxt-transformY-50 fxt-transition-delay-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Mật khẩu" required autocomplete="new-password">
                            <i class="flaticon-padlock"></i>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                
                        <!-- Confirm Password -->
                        <div class="form-group fxt-transformY-50 fxt-transition-delay-4">
                            <i class="flaticon-padlock"></i>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Nhập lại mật khẩu" required autocomplete="new-password">
                        </div>
                
                        <!-- Đăng Ký -->
                        <div class="form-group fxt-transformY-50 fxt-transition-delay-5">
                            <div class="fxt-content-between">
                                <button type="submit" class="fxt-btn-fill">Đăng Ký</button>
                                {{-- <div class="checkbox">
                                    <input id="checkbox1" type="checkbox" required>
                                    <label for="checkbox1">Tôi đồng ý với các điều khoản dịch vụ</label>
                                </div> --}}
                            </div>
                        </div>
                    </form>
                </div>
			
			</div>
		</div>
	</div>
@endsection
