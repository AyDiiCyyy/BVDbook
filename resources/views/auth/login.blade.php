@extends('layouts.auth')

@section('content')
    <section class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-hrading">Login / Register Page</h1>
                        <ul class="breadcrumb-links">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>Login / Register</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="login-register-area mb-60px mt-53px">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 mx-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-bs-toggle="tab" href="#lg1">
                                <h4>Login</h4>
                            </a>
                            <a data-bs-toggle="tab" href="#lg2">
                                <h4>Register</h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="email">{{ __('Email Address') }}</label>
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
                                                <label for="password">{{ __('Password') }}</label>
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
                                                    for="remember">{{ __('Remember Me') }}</label>
                                            </div>

                                            <div class="button-box">
                                                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                                                @if (Route::has('password.request'))
                                                    <a class="btn btn-link"
                                                        href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="lg2" class="tab-pane">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="user-name">Username</label>
                                                <input type="text" name="user-name" class="form-control"
                                                    placeholder="Username" required />
                                            </div>
                                            <div class="mb-3">
                                                <label for="user-password">Password</label>
                                                <input type="password" name="user-password" class="form-control"
                                                    placeholder="Password" required />
                                            </div>
                                            <div class="mb-3">
                                                <label for="user-email">Email</label>
                                                <input name="user-email" class="form-control" placeholder="Email"
                                                    type="email" required />
                                            </div>
                                            <div class="button-box">
                                                <button type="submit"
                                                    class="btn btn-primary"><span>Register</span></button>
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
