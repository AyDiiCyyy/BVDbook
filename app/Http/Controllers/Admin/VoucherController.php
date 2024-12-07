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


        $data['vouchers'] = $query->orderByDesc('id')->paginate(10);


        $currentDate = now();

        foreach ($data['vouchers'] as $voucher) {
            // Nếu voucher đã bị thay đổi thủ công, không cập nhật trạng thái tự động
            if ($voucher->is_manually_updated) {
                continue; // Bỏ qua voucher đã thay đổi thủ công
            }

            $endDate = Carbon::parse($voucher->end);

            if ($endDate->endOfDay()->lessThan($currentDate)) {
                // Nếu ngày kết thúc đã qua và voucher chưa thay đổi trạng thái, cập nhật thành 'expired'
                if ($voucher->status !== 'expired') {
                    $voucher->status = 'expired';
                    $voucher->save();
                }
                $voucher->isExpired = true;
                $voucher->isUpcoming = false;
            } else {
                // Nếu ngày kết thúc chưa qua, cập nhật trạng thái thành 'active'
                if ($voucher->status !== 'active') {
                    $voucher->status = 'active';
                    $voucher->save();
                }
                $voucher->isExpired = false;
                $voucher->isUpcoming = false;
            }
        }

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
            $voucher->update($request->validated());
            return redirect()->route('admin.voucher.index')->with('success', 'Cập nhật voucher thành công.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()])->withInput();
        }
    }


    public function toggleStatus(Request $request, $id)
    {
        try {
            $voucher = Voucher::findOrFail($id);

            // Đổi trạng thái giữa 'active' và 'expired'
            $voucher->status = $voucher->status === 'active' ? 'expired' : 'active';
            $voucher->is_manually_updated = true; // Đánh dấu voucher đã được thay đổi thủ công
            $voucher->save();

            return response()->json([
                'success' => true,
                'newStatus' => $voucher->status === 'active' ? 'Còn hiệu lực' : 'Hết hiệu lực'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
