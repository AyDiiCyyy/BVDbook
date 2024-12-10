<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function index () {
        $user = Auth::user();
        $id = $user->user_vouchers()->pluck('id')->toArray(); // id bảng trung gian trong kho của ng dùng 
        $user_voucher = UserVoucher::whereIn('id',$id)->whereIn('active',[1,2])->pluck('voucher_id')->toArray(); // những id voucher đã có trong kho
        
        $voucher = Voucher::query()
        ->whereNotIn('id',$user_voucher)
        ->where('usage_limit','>',0)
        ->where('status','active')
        ->where('role','1')
        ->where('id','!=',0)
        ->get();
        return view("client/page/voucher", compact('voucher'));
    }
    public function list () {
        $user = Auth::user();
        $id = $user->user_vouchers()->pluck('id')->toArray(); // id bảng trung gian trong kho của ng dùng 
        $user_voucher = UserVoucher::whereIn('id',$id)->whereIn('active',[1])->pluck('voucher_id')->toArray(); // những id voucher đã có trong kho
        
        $voucher = Voucher::query()
        ->whereIn('id',$user_voucher)
        ->where('usage_limit','>',0)
        ->where('status','active')
        ->where('id','!=',0)
        ->get();
        return view("client/page/myVoucher",compact('voucher'));
    }

    public function save_input(Request $request)
    {
        $sku = $request->sku;
        $voucher = Voucher::where('sku', $sku)
            ->where('status', 'active')
            ->where('id','!=',0)
            ->first();
        $user = Auth::user();
        if ($voucher) {
            $id_voucher = $user
                ->user_vouchers()->pluck('id')->toArray();
                $check_tk = UserVoucher::query()
                ->whereIn('id', $id_voucher)
                ->where('voucher_id', $voucher->id)
                ->where('user_id', $user->id)
                ->first(); // check trong tk ng dùng có mã giảm vừa nhập k
            if ($check_tk && $check_tk->active == 2) {
                return response()->json(['status' => 'error', 'message' => 'Bạn đã hết lượt sử dụng voucher này']);
            }
            if ($check_tk && $voucher->role == 1) {
                // trường hợp có mã và là mã tạo bên admin
                    return response()->json(['status' => 'warning', 'message' => 'Mã voucher đã tồn tại trong kho của bạn']);
                
            } elseif ($check_tk && $voucher->role == 0) {
                // trường hợp có mã và là mã đc hoàn 
                if($check_tk->active==0){
                    $check_tk->update(['active' => 1]);
                    return response()->json(['status' => 'success', 'message' => 'Voucher được tặng của bạn đã lưu thành công']);
                }else{
                    return response()->json(['status' => 'warning', 'message' => 'Mã voucher đã tồn tại trong kho của bạn']); 
                    // trường hợp active là 1 rồi
                }
            }
            if (!$check_tk && $voucher->role == 1) {
                // trường hợp k có mã trong kho và mã tạo bên admin
                    $user->user_vouchers()->create(['voucher_id' => $voucher->id, 'active' => 1]);
                    return response()->json(['status' => 'success', 'message' => 'Voucher của bạn đã lưu thành công']);
                
            }
            if (!$check_tk && $voucher->role == 0) {
                // trường hợp k có mã trong kho và mã hoàn
                return response()->json(['status' => 'error', 'message' => 'Bạn không đủ điều kiện sử dụng voucher này!']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Mã giảm giá không tồn tại hoặc đã hết hạn']);
    }
    public function save(Request $request)
    {
        $id = $request->id;
        $voucher = Voucher::where('id', $id)
            ->where('status', 'active')
            ->where('id','!=',0)
            ->first();
        $user = Auth::user();
        if ($voucher) {
            $id_voucher = $user
                ->user_vouchers()->pluck('id')->toArray();
                $check_tk = UserVoucher::query()
                ->whereIn('id', $id_voucher)
                ->where('voucher_id', $voucher->id)
                ->where('user_id', $user->id)
                ->first(); // check trong tk ng dùng có mã giảm vừa nhập k
            if ($check_tk && $check_tk->active == 2) {
                return response()->json(['status' => 'error', 'message' => 'Bạn đã hết lượt sử dụng voucher này']);
            }
            if ($check_tk && $voucher->role == 1) {
                // trường hợp có mã và là mã tạo bên admin
                    return response()->json(['status' => 'warning', 'message' => 'Mã voucher đã tồn tại trong kho của bạn']);
                
            } elseif ($check_tk && $voucher->role == 0) {
                // trường hợp có mã và là mã đc hoàn 
                if($check_tk->active==0){
                    $check_tk->update(['active' => 1]);
                    return response()->json(['status' => 'success', 'message' => 'Voucher được tặng của bạn đã lưu thành công']);
                }else{
                    return response()->json(['status' => 'warning', 'message' => 'Mã voucher đã tồn tại trong kho của bạn']); 
                    // trường hợp active là 1 rồi
                }
            }
            if (!$check_tk && $voucher->role == 1) {
                // trường hợp k có mã trong kho và mã tạo bên admin
                    $user->user_vouchers()->create(['voucher_id' => $voucher->id, 'active' => 1]);
                    return response()->json(['status' => 'success', 'message' => 'Voucher của bạn đã lưu thành công']);
                
            }
            if (!$check_tk && $voucher->role == 0) {
                // trường hợp k có mã trong kho và mã hoàn
                return response()->json(['status' => 'error', 'message' => 'Bạn không đủ điều kiện sử dụng voucher này!']);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Mã giảm giá không tồn tại hoặc đã hết hạn']);
    }
}
