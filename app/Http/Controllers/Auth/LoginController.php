<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // Kiểm tra trạng thái 'active' của người dùng
        if ($user->active == 0 || $user->active == 2) {
            auth()->logout(); // Đăng xuất nếu tài khoản không hợp lệ

            // Chuyển hướng về trang đăng nhập với thông báo lỗi
            return redirect('/login')
                ->withErrors(['email' => 'Tài khoản của bạn đã bị khóa. Vui lòng thử lại sau!']);
        }

        if ($user->role == 0) {
            // Redirect admin to the admin dashboard
            return redirect('/admin');
        }

        // Redirect normal user to the homepage
        return redirect('/');
    }
}
