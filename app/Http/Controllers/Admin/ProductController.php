<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {

        
        return view('admin.products.index');
    }
    public function create()
    {

        return view('admin.products.create');
    }
    public function store(StoreProductRequest $request) {}

    public function edit($id) {}
    public function update(UpdateProductRequest $request, $id) {}
    public function destroy($id) {}
}
