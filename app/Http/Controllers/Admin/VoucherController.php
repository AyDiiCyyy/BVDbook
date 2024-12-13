<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use App\Models\Voucher;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $search = $request->input('search', null);

        // Ngày hiện tại
        $currentDate = now()->startOfDay();;

        // Cập nhật trạng thái tự động
        Voucher::where('end', '<', $currentDate)
            ->update(['status' => 'expired']);

        $query = Voucher::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('sku', 'LIKE', '%' . $search . '%');
            });
        }

        // Thêm điều kiện lọc theo trạng thái
        if ($status === 'active') {
            $query->where('status', 'active');
        } elseif ($status === 'expired') {
            $query->where('status', 'expired');
        }

        $data['vouchers'] = $query->whereNot('id',0)->orderByDesc('id')->paginate(10);
        $data['status'] = $status;
        $data['search'] = $search;

        return view('admin.vouchers.index', $data);
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(StoreVoucherRequest $request)
    {
        try {
            Voucher::create($request->validated());
            return redirect()->route('admin.voucher.index')->with('success', 'Thêm mới voucher thành công.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $data['voucher'] = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', $data);
    }

    public function update(UpdateVoucherRequest $request, $id)
    {
        try {
            $voucher = Voucher::withTrashed()->findOrFail($id);

            // Cập nhật ngày kết thúc trước
            $voucher->end = $request->input('end');
            $voucher->save();
            
            $endDate = Carbon::parse($voucher->end);
            $currentDate = now()->startOfDay();;

            // Kiểm tra nếu người dùng chọn trạng thái "active", và ngày kết thúc đã qua
            if ($request->status === 'active' && $endDate->lessThan($currentDate)) {
                return redirect()->back()
                    ->withErrors(['error' => 'Ngày kết thúc đã qua. Vui lòng cập nhật ngày kết thúc để bật lại trạng thái hoạt động.'])
                    ->withInput();
            }
            // Trạng thái "active" có thể được bật lại nếu ngày kết thúc là hôm nay hoặc trong tương lai
            if ($request->status === 'active' && $voucher->status === 'expired' && $endDate->isToday() || $endDate->greaterThan($currentDate)) {
                $voucher->status = 'active'; // Đặt lại trạng thái thành 'active' nếu ngày kết thúc là hôm nay hoặc trong tương lai
            }
            // Nếu trạng thái là "expired", và ngày kết thúc đã qua thì có thể chuyển thành "expired"
            if ($request->status === 'expired' && $voucher->status === 'active' && $endDate->lessThan($currentDate)) {
                $voucher->status = 'expired'; // Nếu voucher hết hạn, thay đổi trạng thái thành 'expired'
            }

            $voucher->update($request->validated());
            $voucher->save();

            return redirect()->route('admin.voucher.index')->with('success', 'Cập nhật voucher thành công.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()])->withInput();
        }
    }
}
