<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatsController extends Controller
{   
     public function getRevenue(Request $request)
    {
        $filter = $request->input('filter');
        $selectedDate = $request->input('date');
        $revenue = [];
        $labels = [];
        try {
            if (!$filter) {
                return response()->json([
                    'error' => 'Bộ lọc là bắt buộc.',
                ], 400);
            }

            // Lọc 14 ngày
            if ($filter === '14day') {
                // Doanh thu 14 ngày
                $revenueLast14Days = Order::select(
                    DB::raw('DATE(created_at) as day'),
                    DB::raw('SUM(total_money) as revenue')
                )
                    ->where('status', 4)
                    ->where('created_at', '>=', Carbon::now()->subDays(14))
                    ->where('payment_status',1)
                    ->groupBy('day')
                    ->orderBy('day', 'asc')
                    ->get();
                // Kiểm tra nếu có dữ liệu
                if ($revenueLast14Days->isNotEmpty()) {
                    foreach ($revenueLast14Days as $item) {
                        $revenue[] = $item->revenue;
                        $labels[] = Carbon::parse($item->day)->translatedFormat('d/m/Y');
                    }
                } else {
                    $revenue = [0];
                    $labels = ['Không có dữ liệu'];
                }
                // Trạng thái 14 ngày
                $ordersCount = Order::query()
                    ->where('created_at', '>=', Carbon::now()->subDays(14))
                    ->whereIn('status', [1, 2, 5])
                    ->get()
                    ->groupBy('status');
                // Lợi nhuận thuần 14 ngày
                $netProfit = Order::query()
                    ->join('vouchers', 'orders.voucher_id', '=', 'vouchers.id')
                    ->select(DB::raw('SUM(orders.total_money) - SUM(vouchers.discount_amount) 
                    - SUM(
                        CASE 
                            WHEN orders.shipping = 1 THEN 0
                            WHEN orders.shipping = 2 THEN 30000
                            WHEN orders.shipping = 3 THEN 60000
                            ELSE 0
                        END
                    ) AS net_revenue
                '))->where('orders.created_at', '>=', Carbon::now()->subDays(14))
                    ->where('payment_status',1)
                    ->where('orders.status', 4)
                    ->first();
                $netProfitRevenue = $netProfit ? number_format($netProfit->net_revenue, 0, '.', '.') : 0;
                // Top 10 sản phẩm bán chạy 14 ngày
                $bestSellerTop10 = OrderDetail::query()
                    ->join('products', 'order_details.product_id', '=', 'products.id')
                    ->join('orders', 'order_details.order_id', '=', 'orders.id')
                    ->select(
                        'products.name as product_name',
                        DB::raw('SUM(order_details.quantity) as total_sold'),
                        DB::raw('SUM(order_details.price * order_details.quantity) as total_revenue')
                    )
                    ->where('orders.status', 4)
                    ->where('orders.created_at', '>=', Carbon::now()->subDays(14))
                    ->groupBy('product_name', 'order_details.product_id')
                    ->orderByDesc('total_sold')
                    ->limit(10)->get();

                // Tỷ lệ
                $completedOrder = Order::query()
                    ->where('created_at', '>=', Carbon::now()->subDays(14))
                    ->where('status', 4)->count();
                $cancelOrder = Order::query()
                    ->where('created_at', '>=', Carbon::now()->subDays(14))
                    ->where('status', 6)->count();
                return response()->json([
                    'revenue' => $revenue,
                    'labels' => $labels,
                    'netProfitRevenue' => $netProfitRevenue,
                    'pendingOrder' => $ordersCount->get(1, collect())->count(),
                    'orderProcessing' => $ordersCount->get(2, collect())->count(),
                    'cancelConfirm' => $ordersCount->get(5, collect())->count(),
                    'bestSellerTop10' => $bestSellerTop10,
                    'completedOrder' => $completedOrder,
                    'cancelOrder' => $cancelOrder,
                ]);
            }

            // Xử lý theo ngày, tháng, năm nếu filter có selectedDate
            if ($selectedDate) {
                $date = Carbon::parse($selectedDate);
                Carbon::setLocale('vi');
                if ($filter === 'year') {
                    // Tạo ngày đầu tiên của năm từ giá trị người dùng nhập
                    $date = Carbon::createFromFormat('Y', $selectedDate)->startOfYear();
                }
                switch ($filter) {
                    case 'day':
                        // Doanh thu theo ngày 
                        $revenue[] = Order::whereDate('created_at', $date)
                        ->where('status', 4)
                        ->where('payment_status',1)
                        ->sum('total_money');
                        $labels[] = $date->translatedFormat('d/m/Y');
                        // Trạng thái theo ngày
                        $pendingOrder = $this->getOrderStatusCount($date, 1, 'day'); // Trạng thái chờ xác nhận
                        $orderProcessing = $this->getOrderStatusCount($date, 2, 'day'); // Trạng thái đang xử lý
                        $cancelConfirm = $this->getOrderStatusCount($date, 5, 'day'); // Trạng thái hủy xác nhận
                        // Lợi nhuận thuần theo ngày
                        $netProfit = Order::query()
                            ->join('vouchers', 'orders.voucher_id', '=', 'vouchers.id')
                            ->select(DB::raw('SUM(orders.total_money) - SUM(vouchers.discount_amount) 
                                    - SUM(
                                        CASE 
                                            WHEN orders.shipping = 1 THEN 0
                                            WHEN orders.shipping = 2 THEN 30000
                                            WHEN orders.shipping = 3 THEN 60000
                                            ELSE 0
                                        END
                                    ) AS net_revenue
                                '))
                            ->whereDate('orders.created_at', $date)
                            ->where('orders.status', 4)
                            ->where('payment_status',1)
                            ->first();
                        $netProfitRevenue = $netProfit ? number_format($netProfit->net_revenue, 0, '.', '.') : 0;
                        // Top 10 sản phẩm bán chạy theo ngày
                        $bestSellerTop10 = OrderDetail::query()
                            ->join('products', 'order_details.product_id', '=', 'products.id')
                            ->join('orders', 'order_details.order_id', '=', 'orders.id')
                            ->select(
                                'products.name as product_name',
                                DB::raw('SUM(order_details.quantity) as total_sold'),
                                DB::raw('SUM(order_details.price * order_details.quantity) as total_revenue')
                            )
                            ->where('orders.status', 4)
                            ->whereDate('orders.created_at', $date)
                            ->groupBy('product_name', 'order_details.product_id')
                            ->orderByDesc('total_sold')
                            ->limit(10)->get();
                        // Tỷ lệ đơn hàng đã giao và đã hủy theo ngày
                        $completedOrder = Order::query()
                            ->whereDate('created_at', $date)
                            ->where('status', 4)->count();
                        $cancelOrder = Order::query()
                            ->whereDate('created_at', $date)
                            ->where('status', 6)->count();
                        break;
                    case 'month':
                        // Doanh thu theo tháng
                        $revenue[] = Order::whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)
                            ->where('payment_status',1)
                            ->where('status', 4)
                            ->sum('total_money');
                        $labels[] = $date->translatedFormat('m/Y');
                        // Trạng thái theo tháng
                        $pendingOrder = $this->getOrderStatusCount($date, 1, 'month'); // Trạng thái chờ xác nhận
                        $orderProcessing = $this->getOrderStatusCount($date, 2, 'month'); // Trạng thái đang xử lý
                        $cancelConfirm = $this->getOrderStatusCount($date, 5, 'month'); // Trạng thái hủy xác nhận
                        // Lợi nhuận thuần theo tháng
                        $netProfit = Order::query()
                            ->join('vouchers', 'orders.voucher_id', '=', 'vouchers.id')
                            ->select(DB::raw('SUM(orders.total_money) - SUM(vouchers.discount_amount) 
                                    - SUM(
                                        CASE 
                                            WHEN orders.shipping = 1 THEN 0
                                            WHEN orders.shipping = 2 THEN 30000
                                            WHEN orders.shipping = 3 THEN 60000
                                            ELSE 0
                                        END
                                    ) AS net_revenue
                                '))
                            ->whereYear('orders.created_at', $date->year)
                            ->whereMonth('orders.created_at', $date->month)
                            ->where('payment_status',1)
                            ->where('orders.status', 4)
                            ->first();
                        $netProfitRevenue = $netProfit ? number_format($netProfit->net_revenue, 0, '.', '.') : 0;
                        // Top 10 sản phẩm bán chạy theo tháng
                        $bestSellerTop10 = OrderDetail::query()
                            ->join('products', 'order_details.product_id', '=', 'products.id')
                            ->join('orders', 'order_details.order_id', '=', 'orders.id')
                            ->select(
                                'products.name as product_name',
                                DB::raw('SUM(order_details.quantity) as total_sold'),
                                DB::raw('SUM(order_details.price * order_details.quantity) as total_revenue')
                            )
                            ->where('orders.status', 4)
                            ->whereYear('orders.created_at', $date->year)
                            ->whereMonth('orders.created_at', $date->month)
                            ->groupBy('product_name', 'order_details.product_id')
                            ->orderByDesc('total_sold')
                            ->limit(10)->get();
                        // Tỷ lệ đơn hàng đã giao và đã hủy theo tháng
                        $completedOrder = Order::query()
                            ->whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)
                            ->where('status', 4)->count();
                        $cancelOrder = Order::query()
                            ->whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)    
                            ->where('status', 6)->count();
                        break;
                    case 'year':
                        // Doanh thu theo năm
                        $revenue[] = Order::whereYear('created_at', $date->year)->where('status', 4)->where('payment_status',1)->sum('total_money');
                        $labels[] = $date->translatedFormat('Y');
                        // Trạng thái theo năm
                        $pendingOrder = $this->getOrderStatusCount($date, 1, 'year'); // Trạng thái chờ xác nhận
                        $orderProcessing = $this->getOrderStatusCount($date, 2, 'year'); // Trạng thái đang xử lý
                        $cancelConfirm = $this->getOrderStatusCount($date, 5, 'year'); // Trạng thái hủy xác nhận
                        // Lợi nhuận thuần theo năm
                        $netProfit = Order::query()
                            ->join('vouchers', 'orders.voucher_id', '=', 'vouchers.id')
                            ->select(DB::raw('SUM(orders.total_money) - SUM(vouchers.discount_amount) 
                                    - SUM(
                                        CASE 
                                            WHEN orders.shipping = 1 THEN 0
                                            WHEN orders.shipping = 2 THEN 30000
                                            WHEN orders.shipping = 3 THEN 60000
                                            ELSE 0
                                        END
                                    ) AS net_revenue
                                '))
                            ->whereYear('orders.created_at', $date->year)
                            ->where('payment_status',1)
                            ->where('orders.status', 4)
                            ->first();
                        $netProfitRevenue = $netProfit ? number_format($netProfit->net_revenue, 0, '.', '.') : 0;
                        // Top 10 sản phẩm bán chạy theo năm
                        $bestSellerTop10 = OrderDetail::query()
                            ->join('products', 'order_details.product_id', '=', 'products.id')
                            ->join('orders', 'order_details.order_id', '=', 'orders.id')
                            ->select(
                                'products.name as product_name',
                                DB::raw('SUM(order_details.quantity) as total_sold'),
                                DB::raw('SUM(order_details.price * order_details.quantity) as total_revenue')
                            )
                            ->where('orders.status', 4)
                            ->whereYear('orders.created_at', $date->year)
                            ->groupBy('product_name', 'order_details.product_id')
                            ->orderByDesc('total_sold')
                            ->limit(10)->get();
                        // Tỷ lệ đơn hàng đã giao và đã hủy theo năm
                        $completedOrder = Order::query()
                            ->whereYear('created_at', $date->year)
                            ->where('status', 4)->count();
                        $cancelOrder = Order::query()
                            ->whereYear('created_at', $date->year)
                            ->where('status', 6)->count();
                        break;

                    default:
                        // Có thể thêm xử lý lỗi nếu cần, ví dụ:
                        return response()->json([
                            'error' => 'Loại bộ lọc không hợp lệ. Giá trị phải là "day", "month" hoặc "year".'
                        ], 400);
                }
                // Thông báo thành công
                session()->flash('success', 'Lọc dữ liệu thành công!');

                return response()->json([
                    'revenue' => $revenue,
                    'labels' => $labels,
                    'netProfitRevenue' =>  $netProfitRevenue,
                    'pendingOrder' => $pendingOrder,
                    'orderProcessing' => $orderProcessing,
                    'cancelConfirm' => $cancelConfirm,
                    'bestSellerTop10' => $bestSellerTop10,
                    'completedOrder' => $completedOrder,
                    'cancelOrder' => $cancelOrder
                ]);
            }

            // Nếu thiếu selectedDate khi filter không phải '14day'
            return response()->json([
                'error' => 'Ngày/Tháng/Năm là bắt buộc cho bộ lọc này.',
            ], 400);
        } catch (\Exception $e) {
            session()->flash('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
            return response()->json([
                'error' => 'Đã xảy ra lỗi: ' . $e->getMessage(),
            ], 500);
        }
    }
    //Đếm trạng thái 
    function getOrderStatusCount($date, $status, $filter)
    {
        $query = Order::query();

        // Xử lý theo bộ lọc
        if ($filter === 'day') {
            $query->whereDate('created_at', $date);
        } elseif ($filter === 'month') {
            $query->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month);
        } elseif ($filter === 'year') {
            $query->whereYear('created_at', $date->year);
        }

        // Lọc theo trạng thái và trả về số lượng
        return $query->where('status', $status)->count();
    }
    //Hiển thị ra giao diện mặc định
    public function index(Request $request)
    {
        // Tổng doanh thu đơn hàng 
        $revenueTotal = Order::select(
            DB::raw('DATE(created_at) as day'),
            DB::raw('SUM(total_money) as revenue')
        )->where('status', 4)->sum('total_money');
        // dd($revenueTotal);
        // Lợi nhuận thuần
        $netProfit = Order::query()
            ->join('vouchers', 'orders.voucher_id', '=', 'vouchers.id')
            ->select(DB::raw('SUM(orders.total_money) - SUM(vouchers.discount_amount) 
            - SUM(
                CASE 
                    WHEN orders.shipping = 1 THEN 0
                    WHEN orders.shipping = 2 THEN 30000
                    WHEN orders.shipping = 3 THEN 60000
                    ELSE 0
                END
            ) AS net_revenue
        '))
            ->where('orders.status', 4)
            ->first();
        $netProfitRevenue = $netProfit ? number_format($netProfit->net_revenue, 0, '.', '.') : 0;
        // dd($netProfitRevenue);
        //Top 10 sản phẩm bán chạy nhất
        $bestSellerTop10 = OrderDetail::query()
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->select(
                'products.name as product_name',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.price * order_details.quantity) as total_revenue')
            )
            ->where('orders.status', 4)
            ->groupBy('product_name', 'order_details.product_id')
            ->orderByDesc('total_sold')
            ->limit(10)->get();
        // dd( $bestSellerTop10);
        // Xử lý doanh thu của 14 ngày gần nhất
        $revenueLast14Days = Order::select(
            DB::raw('DATE(created_at) as day'),
            DB::raw('SUM(total_money) as revenue')
        )
            ->where('status', 4)
            ->where('created_at', '>=', Carbon::now()->subDays(14))
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        if ($revenueLast14Days->isNotEmpty()) {
            foreach ($revenueLast14Days as $item) {
                $revenue[] = $item->revenue;
                $labels[] = Carbon::parse($item->day)->translatedFormat('d/m/Y');
            }
        } else {
            $revenue = [0];
            $labels = ['Không có dữ liệu'];
        }
        // Hiển thị số lượng từng trạng thái
        $ordersCount = Order::query()
            ->whereIn('status', [1, 2, 5])
            ->get()
            ->groupBy('status');

        $pendingOrder = $ordersCount->get(1, collect())->count();
        $orderProcessing = $ordersCount->get(2, collect())->count();
        $cancelConfirm = $ordersCount->get(5, collect())->count();
        // dd($pendingOrder);
        // Đếm 2 trạng thái
        $completedOrder = Order::query()
            ->where('created_at', '>=', Carbon::now()->subDays(14))
            ->where('status', 4)->count();
        $cancelOrder = Order::query()
            ->where('created_at', '>=', Carbon::now()->subDays(14))
            ->where('status', 6)->count();
        // dd($cancelOrder);
        return view('admin.stats', compact(
            'revenueTotal',
            'revenue',
            'labels',
            'pendingOrder',
            'orderProcessing',
            'cancelConfirm',
            'netProfitRevenue',
            'bestSellerTop10',
            'completedOrder',
            'cancelOrder',
            // 'revenueLast7Days'
        ));
    }
}