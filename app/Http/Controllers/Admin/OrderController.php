<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserVoucher;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $orders = Order::with('user') // Lấy quan hệ user
            ->when($search, function ($query, $search) {
                $query->where('order_code', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($query) use ($search) {
                          $query->where('name', 'like', "%{$search}%");
                      });
            })
            ->paginate(10);

        return view('admin.orders.index', [
            'title' => 'Quản lý đơn hàng',
            'orders' => $orders,
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

        if ($request->status == 6) {
            foreach ($order->OrderDetails as $detail) {
                $product = $detail->product;
                $product->increment('quantity', $detail->quantity);
            }
            if ($order->voucher_id != 0) {
                $voucher = $order->Voucher;

                if ($voucher) {
                    $voucher->increment('usage_limit');
                    $userVoucher = UserVoucher::where('voucher_id', $voucher->id)
                        ->where('user_id', $order->user_id)
                        ->first();

                    if ($userVoucher) {
                        $userVoucher->active = 1;
                        $userVoucher->save();
                    }
                }
            }
        }
        $order->status = $request->status;
        $order->save();

        return response()->json(['status' => true]);
    }
}
