<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderCController extends Controller
{
    const PAGINATION = 10;
    public function waiting()
    {
        $nav = 'Chờ thanh toán';
        $user = Auth::user();
        $orders = $user->Orders()
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(self::PAGINATION);
        return view("client.account.waiting", compact('orders','nav'));
    }
    public function repayment($id)
    {
        $order = Order::find($id);
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('check');
        $vnp_TmnCode = "MPGWRLQW"; //Mã website tại VNPAY 
        $vnp_HashSecret = "1V5W6FU2VSYO7UIAQ29WQ3GG6L0R8KMK"; //Chuỗi bí mật
        $vnp_TxnRef = $order->order_code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'thanh toan vnpay'; // ghi chú thanh toán
        $vnp_OrderType = 300000;  // trong thực tế mới quan trọng nhằm xác định mục đích thanh toán, 300000 là thanh toán cho thương mại điện tử
        $vnp_Amount = $order->total_money * 100;
        $vnp_Locale = 'VN';  // ngôn ngữ
        $vnp_BankCode = "NCB"; // có thể để trống thì sau thanh toán sẽ bắt chọn
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            // return response()->json(['status' => 'url', 'url' => $vnp_Url]);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo
    }

    public function cancel($id)
    {
        $order = Order::find($id);
        $order = $order->update(['status'=>5]);
        return redirect()->back()->with('status_succeed', 'Huỷ đơn thành công!');
    }

    public function all()
    {
        $nav = 'Tất cả';
        $user = Auth::user();
        $orders = $user->Orders()
            ->orderBy('created_at', 'desc')
            ->paginate(self::PAGINATION);
        return view("client.account.waiting", compact('orders','nav'));
    }
    public function transport()
    {
        $nav = 'Vận chuyển';
        $user = Auth::user();
        $orders = $user->Orders()
            ->whereIn('status', [2, 3])
            ->orderBy('created_at', 'desc')
            ->paginate(self::PAGINATION);
        return view("client.account.waiting", compact('orders','nav'));
    }
    public function waitCancel()
    {
        $nav = 'Chờ xác nhận huỷ đơn';
        $user = Auth::user();
        $orders = $user->Orders()
            ->where('status', 5)
            ->orderBy('created_at', 'desc')
            ->paginate(self::PAGINATION);
        return view("client.account.waiting", compact('orders','nav'));
    }
    public function complete()
    {
        $nav = 'Hoàn thành';
        $user = Auth::user();
        $orders = $user->Orders()
            ->where('status', 4)
            ->orderBy('created_at', 'desc')
            ->paginate(self::PAGINATION);
        return view("client.account.waiting", compact('orders','nav'));
    }
    public function canceled()
    {
        $nav = 'Huỷ';
        $user = Auth::user();
        $orders = $user->Orders()
            ->where('status', 6)
            ->orderBy('created_at', 'desc')
            ->paginate(self::PAGINATION);
        return view("client.account.waiting", compact('orders','nav'));
    }
}
