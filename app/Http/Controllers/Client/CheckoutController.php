<?php

namespace App\Http\Controllers\Client;

use App\Models\Voucher;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Mail\CheckoutEmail;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function checkout()
    {
        try {
            session()->forget('voucher');
            $user = Auth::user();
            $products = $user->Carts;
            if ($products->isEmpty()) {
                return back();
            }
            $sum = 0;
            foreach ($products as $product) {
                $sum += $product->products->price * $product->quantity;
            }
            $vouchersId = $user
                ->user_vouchers()
                ->where('active', 1)
                ->pluck('voucher_id')
                ->toArray();

            $vouchers = Voucher::whereIn('id', $vouchersId)
                ->where('min_order_amount', '<=', $sum)
                ->where('usage_limit', '>', 0)
                ->where('end', '>=', now('UTC'))
                ->orderBy('discount_amount', 'desc')
                ->get();
            return view("client/page/checkout", compact('user', 'products', 'sum', 'vouchers'));
        } catch (\Exception $e) {
            log::error($e->getMessage());
            return back()->with(['status_failed' => $e->getMessage()]);
        }
    }

    public function checkvoucher(Request $request)
    {
        $sum = 0;
        $sku = $request->sku;
        $voucher = Voucher::where('sku', $sku)
            ->where('status', 'active')
            ->where('deleted_at', null)
            ->where('end', '>=', now('UTC'))
            ->first();
        $user = Auth::user();
        $products = $user->Carts;
        foreach ($products as $product) {
            $sum += $product->products->price * $product->quantity;
        }  // tính giá tổng của giỏ hàng hiện tại

        if ($voucher) {
            if ($voucher->min_order_amount >= $request->sum) {
                return response()->json(['status' => 'error', 'message' => 'Đơn hàng của bạn không đủ điều kiện sử dụng mã giảm giá!']);
            }
            $check_tk = $user
                ->user_vouchers()
                ->where('voucher_id', $voucher->id)
                ->where('user_id', $user->id)
                ->first(); // check trong tk ng dùng có mã giảm vừa nhập k

            if ($check_tk && $check_tk->active == 2) {
                return response()->json(['status' => 'error', 'message' => 'Bạn đã hết lượt sử dụng voucher này']);
            }
            if ($check_tk && $voucher->role == 1) {
                // trường hợp có mã và là mã tạo bên admin
                if ($sum == $request->sum) { // so sánh giá tổng hiện tại vs thời điểm vào trang checkout
                    if (session('voucher') == $voucher) {
                        return response()->json(['status' => 'voucher da su dung']);
                    }
                    session()->forget('voucher');
                    session(['voucher' => $voucher]);
                    return response()->json(['status' => 'success', 'voucher' => $voucher, 'sum' => $sum]);
                } else {
                    return response()->json(['status' => 'warning', 'message' => 'Giỏ hàng đã có sự thay đổi']);
                }
            } elseif ($check_tk && $voucher->role == 0) {
                // trường hợp có mã và là mã đc hoàn 
                $check_tk->update(['active' => 1]);
                if ($sum == $request->sum) { // so sánh giá tổng hiện tại vs thời điểm vào trang checkout
                    if (session('voucher') == $voucher) {
                        return response()->json(['status' => 'voucher da su dung']);
                    }
                    session()->forget('voucher');
                    session(['voucher' => $voucher]);
                    return response()->json(['status' => 'success', 'voucher' => $voucher, 'sum' => $sum]);
                } else {
                    return response()->json(['status' => 'warning', 'message' => 'Giỏ hàng đã có sự thay đổi']);
                }
            }
            if (!$check_tk && $voucher->role == 1) {
                // trường hợp k có mã trong kho và mã tạo bên admin
                $user->user_vouchers()->create(['voucher_id' => $voucher->id, 'active' => 1]);
                if ($sum == $request->sum) { // so sánh giá tổng hiện tại vs thời điểm vào trang checkout
                    if (session('voucher') == $voucher) {
                        return response()->json(['status' => 'voucher da su dung']);
                    }
                    session()->forget('voucher');
                    session(['voucher' => $voucher]);
                    return response()->json(['status' => 'success', 'voucher' => $voucher, 'sum' => $sum]);
                } else {
                    return response()->json(['status' => 'warning', 'message' => 'Giỏ hàng đã có sự thay đổi']);
                }
            }
            if (!$check_tk && $voucher->role == 0) {
                // trường hợp k có mã trong kho và mã hoàn
                return response()->json(['status' => 'error', 'message' => 'Bạn không đủ điều kiện sử dụng voucher này!']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Mã giảm giá không tồn tại hoặc đã hết hạn']);
    }
    public function usevoucher(Request $request)
    {
        $sum = 0;
        $id = $request->id;
        $voucher = Voucher::where('id', $id)
            ->where('status', 'active')
            ->where('deleted_at', null)
            ->where('end', '>=', now('UTC'))
            ->first();
        $user = Auth::user();
        $products = $user->Carts;
        foreach ($products as $product) {
            $sum += $product->products->price * $product->quantity;
        }  // tính giá tổng của giỏ hàng hiện tại

        if ($voucher) {
            if ($voucher->min_order_amount >= $request->sum) {
                return response()->json(['status' => 'error', 'message' => 'Đơn hàng của bạn không đủ điều kiện sử dụng mã giảm giá!']);
            }
            $check_tk = $user
                ->user_vouchers()
                ->where('voucher_id', $voucher->id)
                ->where('user_id', $user->id)
                ->first(); // check trong tk ng dùng có mã giảm vừa nhập k

            if ($check_tk && $check_tk->active == 2) {
                return response()->json(['status' => 'error', 'message' => 'Bạn đã hết lượt sử dụng voucher này']);
            }
            if ($check_tk && $voucher->role == 1) {
                // trường hợp có mã và là mã tạo bên admin
                if ($sum == $request->sum) { // so sánh giá tổng hiện tại vs thời điểm vào trang checkout
                    if (session('voucher') == $voucher) {
                        return response()->json(['status' => 'voucher da su dung']);
                    }
                    session()->forget('voucher');
                    session(['voucher' => $voucher]);
                    return response()->json(['status' => 'success', 'voucher' => $voucher, 'sum' => $sum]);
                } else {
                    return response()->json(['status' => 'warning', 'message' => 'Giỏ hàng đã có sự thay đổi']);
                }
            } elseif ($check_tk && $voucher->role == 0) {
                // trường hợp có mã và là mã đc hoàn 
                $check_tk->update(['active' => 1]);
                if ($sum == $request->sum) { // so sánh giá tổng hiện tại vs thời điểm vào trang checkout
                    if (session('voucher') == $voucher) {
                        return response()->json(['status' => 'voucher da su dung']);
                    }
                    session()->forget('voucher');
                    session(['voucher' => $voucher]);
                    return response()->json(['status' => 'success', 'voucher' => $voucher, 'sum' => $sum]);
                } else {
                    return response()->json(['status' => 'warning', 'message' => 'Giỏ hàng đã có sự thay đổi']);
                }
            }
            if (!$check_tk && $voucher->role == 1) {
                // trường hợp k có mã trong kho và mã tạo bên admin
                $user->user_vouchers()->create(['voucher_id' => $voucher->id, 'active' => 1]);
                if ($sum == $request->sum) { // so sánh giá tổng hiện tại vs thời điểm vào trang checkout
                    if (session('voucher') == $voucher) {
                        return response()->json(['status' => 'voucher da su dung']);
                    }
                    session()->forget('voucher');
                    session(['voucher' => $voucher]);
                    return response()->json(['status' => 'success', 'voucher' => $voucher, 'sum' => $sum]);
                } else {
                    return response()->json(['status' => 'warning', 'message' => 'Giỏ hàng đã có sự thay đổi']);
                }
            }
            if (!$check_tk && $voucher->role == 0) {
                // trường hợp k có mã trong kho và mã hoàn
                return response()->json(['status' => 'error', 'message' => 'Bạn không đủ điều kiện sử dụng voucher này!']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Mã giảm giá không tồn tại hoặc đã hết hạn']);
    }

    public function pay(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $sum = 0;
            $products = $user->Carts;
            if ($products->isEmpty()) {
                return response()->json(['status' => 'error', 'message' => 'Đã xảy ra lỗi trong quá trình mua hàng']);
            }
            foreach ($products as $product) {
                $sum += $product->products->price * $product->quantity;
            }  // tính giá tổng của giỏ hàng hiện tại
            // xử lý trừ voucher
            $id = session('voucher')->id ?? null;
            $voucher = Voucher::where('id', $id)
                ->where('status', 'active')
                ->where('deleted_at', null)
                ->where('end', '>=', now('UTC'))
                ->where('min_order_amount', '<=', $sum)
                ->first();
            if ($voucher && $voucher->usage_limit > 0) {
                $voucher->decrement('usage_limit', 1); // trừ 1 voucher

                $check = $user
                    ->user_vouchers()
                    ->where('voucher_id', $voucher->id)
                    ->where('user_id', $user->id)
                    ->where('active', 1)
                    ->first(); // check voucher có đủ điều kiện sử dụng k
                if ($check) {
                    $check->update(['active' => 2]); // đánh dấu voucher đã sử dụng
                }
            } else {
                if (session('voucher')) {
                    return response()->json(['status' => 'error', 'message' => 'Đã xảy ra lỗi trong quá trình mua hàng']);
                }
            }

            // tạo order
            do {
                $orderCode = 'SKY-' . Str::upper(Str::random(8)); // Tạo mã ngẫu nhiên
            } while (Order::where('order_code', $orderCode)->exists()); // Kiểm tra trùng lặp

            // Tạo đơn hàng
            $order = $user->Orders()->create([
                'order_code' => $orderCode,
                'voucher_id' => $voucher->id ?? 0,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'payment' => $request->payment,
                'shipping' => 1,
                'total_money' => ($voucher?->id == null) ? $sum : $sum - $voucher->discount_amount,
                'status' => 1,
                'payment_status' => 0,
            ]);
            // xử lý trừ sp
            $cartItems = $user->Carts;
            foreach ($cartItems as $cart) {
                $product = $cart->products;
                $product->decrement('quantity', $cart->quantity); // trừ  sp

                // thêm sp vào order-detail
                $order->OrderDetails()->create([
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $cart->quantity,
                    'unit_price' => $product->price * $cart->quantity,
                ]);
                // xoá giỏ hàng
                $cart->delete();
            }
            if ($request->payment == 0) {

                Mail::to($request->email)->send(new CheckoutEmail($order));
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Đặt hàng thành công']);
            } else {
                // thanh toán online
                Mail::to($request->email)->send(new CheckoutEmail($order));
                DB::commit();
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
                    // header('Location: ' . $vnp_Url);
                    return response()->json(['status' => 'url', 'url' => $vnp_Url]);
                    // die();
                } else {
                    echo json_encode($returnData);
                }
                // vui lòng tham khảo thêm tại code demo
            }
        } catch (\Exception $e) {
            // Roll back the transaction if anything fails
            DB::rollBack();

            // Log the error or display an error message
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function check(Request $request)
    {
        $vnp_HashSecret = "1V5W6FU2VSYO7UIAQ29WQ3GG6L0R8KMK"; //Chuỗi bí mật
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                $date = $request->vnp_PayDate;
                $date = Carbon::createFromFormat('YmdHis', $date)->format('d-m-Y');
                $order = Order::where('order_code',$request->vnp_TxnRef)->first();
                $order = $order->update(['payment_status'=>1]);
                return view('client/page/thankyou', compact('request', 'date'));
            } else {
                $date = $request->vnp_PayDate;
                $date = Carbon::createFromFormat('YmdHis', $date)->format('d-m-Y');
                return view('client/page/payerror',compact('request','date'));
            }
        } else {
            return view('client/page/error');
        }
    }
}
