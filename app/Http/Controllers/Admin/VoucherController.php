<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use App\Models\Voucher;
use Exception;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'active');

        if ($status == 'deleted') {
            // Lấy các voucher đã bị xóa mềm
            $data['vouchers'] = Voucher::onlyTrashed()->orderByDesc('id')->paginate(10);
        } else {
            // Lấy các voucher chưa bị xóa mềm
            $data['vouchers'] = Voucher::orderByDesc('id')->paginate(10);
        }

        $currentDate = now();

        foreach ($data['vouchers'] as $voucher) {
            if ($voucher->start > $currentDate) {
                // Nếu ngày bắt đầu lớn hơn ngày hiện tại, voucher sắp ra mắt
                $voucher->isUpcoming = true;
                $voucher->isExpired = false;
            } elseif ($voucher->end < $currentDate) {
                // Nếu ngày kết thúc nhỏ hơn ngày hiện tại, voucher đã hết hạn
                $voucher->isExpired = true;
                $voucher->isUpcoming = false;
            } else {
                // Voucher đang hoạt động
                $voucher->isExpired = false;
                $voucher->isUpcoming = false;
            }
        }
        $data['status'] = $status;

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
            return redirect()->route('vouchers.index')->with('success', 'Thêm mới voucher thành công.');
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
            $voucher->update($request->validated());
            return redirect()->route('vouchers.index')->with('success', 'Cập nhật voucher thành công.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $voucher = Voucher::withTrashed()->findOrFail($id);

            if ($voucher->trashed()) {
                // Nếu bản ghi đã bị xóa mềm, thì xóa vĩnh viễn
                $voucher->forceDelete();
                return redirect()->route('vouchers.index')->with('success', 'Xóa vĩnh viễn voucher thành công.');
            } else {
                // Nếu bản ghi chưa bị xóa mềm, thì xóa mềm
                $voucher->delete();
                return redirect()->route('vouchers.index')->with('success', 'Xóa voucher thành công.');
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    public function restore($id)
{
    try {
        $voucher = Voucher::onlyTrashed()->findOrFail($id);
        $voucher->restore();
        return redirect()->route('vouchers.index')->with('success', 'Khôi phục voucher thành công.');
    } catch (Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
    }
}
}
