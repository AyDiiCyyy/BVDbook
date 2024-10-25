<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){

        
        return view('admin.products.index');
        
    }
    public function create(){
        
        return view('admin.products.create');
    }
    public function store(StoreProductRequest $request){
        $data = $request->all();
        Product::create($data);
        return redirect()->route('admin.products.index')->with('message','Create successfully');
    }

    public function update(UpdateProductRequest $request, $id)
{
    $product = Product::findOrFail($id);

    // Truyền sản phẩm hiện tại vào request
    $request->setCurrentProduct($product);

    // Nếu không có lỗi xác thực, tiến hành cập nhật
    $product->update($request->validated());

    return redirect()->route('products.index')->with('success', 'Product updated successfully');
}
}
