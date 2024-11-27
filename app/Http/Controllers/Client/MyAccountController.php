<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $orderCount = Order::where('user_id', $user->id)->count();
        return view('client.account.my-account', compact('user', 'orderCount'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('client.account.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'address.max' => 'Địa chỉ không quá 255 ký tự.',
            'phone.max' => 'Số điện thoại không quá 15 ký tự.',
            'avatar.image' => 'Ảnh đại diện phải là hình ảnh.',
            'avatar.max' => 'Kích thước ảnh không vượt quá 2MB.',
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar)); // Xóa ảnh cũ
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
        $user->save();

        return redirect()->route('client.account.update-profile')->with('success', 'Thông tin đã được cập nhật!');
    }


    public function showChangePasswordForm()
    {
        return view('client.account.change-password');
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8|different:current_password',
        ], [
            'current_password.required' => 'Mật khẩu hiện tại là bắt buộc.',
            'password.required' => 'Mật khẩu mới là bắt buộc.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'password.different' => 'Mật khẩu mới không thể giống mật khẩu hiện tại.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('client.account.change-password')->with('success', 'Mật khẩu đã được cập nhật thành công!');
    }
    //
    public function showOrders()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        $orders = $orders->map(function ($order) {
            $order->status_label = $this->getStatusLabel($order->status);
            return $order;
        });

        return view('client.account.orders', compact('user', 'orders'));
    }
    private function getStatusLabel($status)
    {
        //mảng trạng thái
        $statusLabels = [
            1 => 'Chờ xác nhận',
            2 => 'Đang vận chuyển',
            3 => 'Chưa hoàn thành',
            4 => 'Đã hoàn thành',
            5 => 'Đã hủy',
        ];
        return $statusLabels[$status] ?? 'Không xác định';
    }

    public function showOrderDetail($orderId)
    {
        $user = Auth::user();

        $order = Order::where('user_id', $user->id)
            ->where('id', $orderId)
            ->with('orderDetails')
            ->first();

        if (!$order) {
            return redirect()->route('client.account.orders')->with('error', 'Đơn hàng không tồn tại.');
        }

        if ($order->orderDetails->isEmpty()) {
            return redirect()->route('client.account.orders')->with('error', 'Đơn hàng không có sản phẩm.');
        }

        return view('client.account.order-detail', compact('order'));
    }



    public function cancelOrder($orderId)
    {
        $user = Auth::user();

        $order = Order::where('user_id', $user->id)->where('id', $orderId)->first();

        if (!$order || $order->status == 4 || $order->status == 5) {
            return redirect()->route('client.account.orders')->with('error', 'Không thể hủy đơn hàng này.');
        }

        $order->status = 5;
        $order->save();

        return redirect()->route('client.account.orders')->with('success', 'Đơn hàng đã được hủy.');
    }



}
