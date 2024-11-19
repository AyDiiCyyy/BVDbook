@extends('layouts.auth')

@section('content')
    <!-- Giao diện breadcrumb từ file trên -->
    <section class="breadcrumb-area" style="margin-top: -50px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-hrading">Đặt lại mật khẩu</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="{{ url('/') }}">Trang chủ</a></li>
                            <li>Đặt lại mật khẩu</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nội dung form reset password giữ nguyên từ file dưới -->
    <div class="container" style="margin-top: -50px">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Đặt lại mật khẩu') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Yêu cầu đặt lại mật khẩu') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
