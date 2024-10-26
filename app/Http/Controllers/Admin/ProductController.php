<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    const PAGINATION = 2;
    public function index(){
        $products = Product::query()->orderBy('order')->paginate(self::PAGINATION);
        return view('admin/products/index', compact('products'));
    }
    public function changeBest(Request $request){
        $item = Product::find($request->id);
        $item->best = $item->best == 1 ? 0 : 1;
        $item->save();
        return $item;
    }
    public function changeActive(Request $request){
        $item = Product::find($request->id);
        $item->active = $item->active == 1 ? 0 : 1;
        $item->save();
        return $item;
    }
    public function changeOrder(Request $request){
        $item = Product::find($request->id);
        $item->order = $request->order;
        $item->save();
        return $item;
    }
    public function create (){
        $categories = Category::query()->where('parent_id',0)->get();
        dd($categories[0]->childrenRecursive);
        return view('admin.products.create');
    }
    public function store (StoreProductRequest $request){
        dd($request->all());
    }
}
