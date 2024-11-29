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

    // SELECT categories.name as category_name, orders.status , SUM(order_details.quantity) as total_sold  FROM order_details 
    // JOIN orders ON order_details.order_id = orders.id
    // JOIN products ON order_details.product_id = products.id
    // JOIN category_products ON  products.id = category_products.product_id
    // JOIN categories ON category_products.category_id = categories.id 
    // WHERE orders.status = 4
    // GROUP BY category_name
    // ORDER BY  total_sold DESC
    // LIMIT 10;
    public function getRevenue(Request $request)
    {
        $filter = $request->input('filter');
        $selectedDate = $request->input('date');

        $revenue = [];
        $labels = [];
        try {
            // Kiểm tra xem giá trị selectedDate có hợp lệ không
            if (!$selectedDate) {
                return response()->json([
                    'error' => 'Ngày/tháng/năm không hợp lệ.',
                ], 400);
            }

            // Chuyển đổi selectedDate thành đối tượng Carbon
            $date = Carbon::parse($selectedDate);
            Log::info('Received Date: ' . $selectedDate); // Ghi log giá trị nhận được từ frontend

            // Kiểm tra nếu có filter và selectedDate
            if ($filter && $selectedDate) {
                // Set up Tiếng Việt cho Carbon
                Carbon::setLocale('vi');

                // Kiểm tra nếu filter là 'year'
                if ($filter === 'year') {
                    // Tạo ngày đầu tiên của năm từ giá trị người dùng nhập
                    $date = Carbon::createFromFormat('Y', $selectedDate)->startOfYear();
                }

                // Kiểm tra nếu ngày, tháng, hoặc năm không hợp lệ
                // if (!$date || !$date->isValid()) {
                //     return response()->json([
                //         'error' => 'Ngày không hợp lệ.',
                //     ], 400);
                // }

                // Xử lý theo loại bộ lọc
                if ($filter === 'day') {
                    // Lọc theo ngày
                    $revenue[] = Order::whereDate('created_at', $date)->sum('total_money');
                    $labels[] = $date->toDateString();
                } elseif ($filter === 'month') {
                    // Lọc theo tháng
                    $revenue[] = Order::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->sum('total_money');
                    $labels[] = $date->translatedFormat('F Y');
                } elseif ($filter === 'year') {
                    // Lọc theo năm
                    for ($month = 1; $month <= 12; $month++) {
                        $revenue[] = Order::whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $month)
                            ->sum('total_money');
                        $labels[] = Carbon::create($date->year, $month, 1)->translatedFormat('F');
                    }
                    // $revenue[]  = Order::whereYear('created_at', $date->year)->sum('total_money');
                    // $labels[] = $date->translatedFormat('Y');
                } else {
                    return response()->json([
                        'error' => 'Loại bộ lọc không hợp lệ. Giá trị phải là "day", "month", hoặc "year".',
                    ], 400);
                }
            }

            return response()->json([
                'revenue' => $revenue,
                'labels' => $labels,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Đã xảy ra lỗi: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function index(Request $request)
    {
        $selectedDate = $request->input('date');
        // dd($selectedDate);
        $pendingOrder = Order::query()->where('status', 1)->count();
        // $confirmedOrder = Order::query()->where('status', 2)->count();
        $shippingOrder = Order::query()->where('status', 3)->count();
        $completedOrder = Order::query()->where('status', 4)->count();
        $canceledOrder = Order::query()->where('status', 5)->count();


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
            ->groupBy('product_name', 'order_details.product_id')->orderByDesc('total_sold')->limit(10)->get();
        // Xử lý doanh thu của 7 ngày gần nhất
        $revenueLast14Days = Order::select(
            DB::raw('DATE(created_at) as day'),
            DB::raw('SUM(total_money) as revenue')
        )->where('created_at', '>=', Carbon::now()->subDays(14))
            ->groupBy('day')->orderBy('day', 'asc')->get();
        foreach ($revenueLast14Days as $item) {
            $revenue[] = $item->revenue;
            $labels[] = Carbon::parse($item->day)->translatedFormat('d/m/Y');
        }
        // Tỷ lệ bán chạy
        $rateProductsSell = OrderDetail::query()
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->select(
                'products.name as product_name',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.price * order_details.quantity) as total_revenue')
            )
            ->where('orders.status', 4)
            ->groupBy('product_name', 'order_details.product_id')
            ->orderByDesc('total_revenue')
            ->get();
        // Phân nhóm sản phẩm bán chạy
        $bestSelling = $rateProductsSell->filter(function ($product) {
            return $product->total_sold >= 20; 
        });

        $averageSelling = $rateProductsSell->filter(function ($product) {
            return $product->total_sold >= 6 && $product->total_sold < 20; 
        });

        $lowSelling = $rateProductsSell->filter(function ($product) {
            return $product->total_sold < 6; 
        });
        $totalProducts = $rateProductsSell->count();
       
        $bestSellingPercentage = ($bestSelling->count() / $totalProducts) * 100;
        
        $averageSellingPercentage = ($averageSelling->count() / $totalProducts) * 100;
        $lowSellingPercentage = ($lowSelling->count() / $totalProducts) * 100;
        // dd($lowSelling->count());

        return view('admin.stats', compact(
            'pendingOrder',
            'shippingOrder',
            'completedOrder',
            'canceledOrder',
            'bestSellerTop10',
            'revenue',
            'labels',
            'bestSellingPercentage',
            'averageSellingPercentage',
            'lowSellingPercentage',

            // 'revenueLast7Days'

        ));
    }
}
