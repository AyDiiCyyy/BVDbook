<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{   
    use StorageImageTrait;
    const PAGINATION = 10;
    public function index(){
        // $categories = Category::query()->where('parent_id',0)->get();
        $products = Product::query()->orderBy('order')->paginate(self::PAGINATION);
        return view('admin.products.index',compact('products'));
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
        return view('admin.products.create',compact('categories'));
    }
    public function store (StoreProductRequest $request) {
        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'sku' => $request->sku,
            'price' => $request->price,
            'sale' => $request->sale??null,
            'short_description' => $request->short_description??'',
            'long_description' => $request->long_description??'',
            'author' => $request->author,
            'publisher' => $request->publisher,
            'released' => $request->released,
            'weight' => $request->weight,
            'page' => $request->page,
            'quantity' => $request->quantity,
            'order' => $request->order,
            'best' => $request->best??0,
            'active' => $request->active??0,
        ];

        

        

        $data['image'] = StorageImageTrait::storageTraitUpload($request,'image','products')['path']??'';
        $product = Product::create($data); // sản phẩm có id là 4

        // $request->categories    mảng danh mục chọn từ select ['0'=>'1',  '1'=>'2']

        foreach($request->categories as $category){  
            $product->ProductCategories()->create([
                'category_id' => $category
            ]);
        }

        $product_images = StorageImageTrait::storageTraitUploadMultiple($request,'product_image','products'); // chuyển ảnh vào nơi chứa ảnh

        foreach($product_images as $product_image){
            $product->galleries()->create(['image' => $product_image['path']]);
        }


        return redirect()->route('admin.product.index')->with('status_succeed','Thêm sản phẩm thành công');


    }
}
