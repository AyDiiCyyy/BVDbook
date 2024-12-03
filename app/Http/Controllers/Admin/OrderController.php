<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $search = $request->input('order_code'); 
        $payment = $request->input('payment'); 
        $payment_status = $request->input('payment_status'); 
        $status = $request->input('status'); 
    
    
        $orders = Order::with('user');
    
       
        if ($search) {
            $orders->where('order_code', 'like', "%{$search}%")
                   ->orWhereHas('user', function ($query) use ($search) {
                       $query->where('name', 'like', "%{$search}%");
                   });
        }
    
        if ($payment !== null) { 
            $orders->where('payment', $payment);
        }
    
        if ($payment_status !== null) { 
            $orders->where('payment_status', $payment_status);
        }
    
        if ($status !== null) { 
            $orders->where('status', $status);
        }
    
       
        $orders = $orders->paginate(10);
    
        return view('admin.orders.index', [
            'title' => 'Quản lý đơn hàng',
            'orders' => $orders,
            'request' => $request, 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['OrderDetails.product', 'Voucher'])->findOrFail($id);
        
        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changeActive(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:orders,id',
            'status' => 'required|integer|min:1|max:6',
        ]);

        $order = Order::with(['OrderDetails', 'Voucher'])->find($request->id);

        if ($order->status == 6) { 
            return response()->json(['status' => false, 'message' => 'Đơn hàng đã hủy, không thể thay đổi trạng thái.']);
        }

        if ($order->status >= $request->status) {
            return response()->json(['status' => false, 'message' => 'Không thể lùi trạng thái đơn hàng.']);
        }

        // Kiểm tra nếu trạng thái đang giao hàng và chuyển sang đã giao hàng
        if ($order->status == 3 && $request->status == 4) {
            // Nếu đơn hàng là Ship COD và chưa thanh toán
            if ($order->payment == 0 && $order->payment_status == 0) {
                // Cập nhật trạng thái thanh toán thành đã thanh toán
                $order->payment_status = 1; // 1: Đã thanh toán
            }
        }

        if ($request->status == 6) { // Nếu trạng thái là đã hủy
            // Hoàn lại số lượng sản phẩm
            foreach ($order->OrderDetails as $detail) {
                $product = $detail->product; 
                $product->increment('quantity', $detail->quantity);
            }

            // Kiểm tra xem đơn hàng có sử dụng voucher không
            if ($order->voucher_id) {
                // Tìm voucher đã sử dụng
                $userVoucher = UserVoucher::where('voucher_id', $order->voucher_id)
                    ->where('user_id', $order->user_id)
                    ->first();

                if ($userVoucher) {
                    // Cập nhật trạng thái active về 1 để người dùng có thể sử dụng lại
                    $userVoucher->active = 1;
                    $userVoucher->save();

                    // Cập nhật lại usage_limit của voucher
                    $voucher = Voucher::find($order->voucher_id);
                    if ($voucher) {
                        $voucher->increment('usage_limit', 1); // Hoàn lại usage_limit
                    }
                }
            }

            // Kiểm tra phương thức thanh toán và trạng thái thanh toán
            if ($order->payment == 1 && $order->payment_status == 1) { // Thanh toán online và đã thanh toán
                // Tạo voucher hoàn tiền với giá trị 100% tổng tiền
                $voucherAmount = $order->total_money; // Cập nhật giá trị voucher thành 100%

                // Tạo mã voucher ngẫu nhiên
                do {
                    $voucherCode = 'SKY-' . Str::upper(Str::random(8)); // Tạo mã ngẫu nhiên
                } while (Voucher::where('sku', $voucherCode)->exists()); // Kiểm tra trùng lặp

                $voucher = new Voucher([
                    'name' => 'Hoàn tiền cho đơn hàng #' . $order->order_code,
                    'sku' => $voucherCode,
                    'discount_amount' => $voucherAmount,
                    'min_order_amount' => 0,
                    'usage_limit' => 1,
                    'description' => 'Voucher hoàn tiền cho đơn hàng #' . $order->order_code,
                    'start' => now(),
                    'end' => now()->addMonths(1), 
                    'status' => 'active',
                    'role' => 0, 
                ]);
                $voucher->save();

                // Tạo bản ghi UserVoucher với role là 0
                UserVoucher::create([
                    'voucher_id' => $voucher->id,
                    'user_id' => $order->user_id,
                    'active' => 0, // Chỉ cho phép người dùng này sử dụng
                ]);

                // Gửi email hoàn tiền
                Mail::to($order->user->email)->send(new \App\Mail\RefundVoucherMail($voucher, $order->order_code));
            }

            // Cập nhật trạng thái đơn hàng
            $order->status = $request->status;
            $order->save();

            return response()->json(['status' => true, 'message' => 'Đơn hàng đã được hủy và voucher hoàn tiền đã được gửi qua email.']);
        }

        // Cập nhật trạng thái đơn hàng
        $order->status = $request->status;
        $order->save();

        return response()->json(['status' => true, 'message' => 'Trạng thái đơn hàng đã được cập nhật.']);
    }
}