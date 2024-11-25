<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $ordersList = Order::query()->paginate(10);
        // dd($getOrdersList);
        return view('admin.orders.index',compact('ordersList'));
    }
    public function show($id){
        $orderDetail = Order::query()->findOrFail($id);
        // dd($orderDetail);
        return view('admin.orders.show','orderDetail');
    }
}
