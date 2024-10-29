<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{   
    use StorageImageTrait;
    const PAGINATION = 10;
    public function index()
    {
        $products = Product::query()->orderBy('order')->orderBy('id', 'desc')->paginate(self::PAGINATION);
        return view('admin/products/index', compact('products'));
    }
    public function changeBest(Request $request)
    {
        $item = Product::find($request->id);
        $item->best = $item->best == 1 ? 0 : 1;
        $item->save();
        return $item;
    }
    public function changeActive(Request $request)
    {
        $item = Product::find($request->id);
        $item->active = $item->active == 1 ? 0 : 1;
        $item->save();
        return $item;
    }
    public function changeOrder(Request $request)
    {
        $item = Product::find($request->id);
        $item->order = $request->order;
        $item->save();
        return $item;
    }
    public function create()
    {
        $categories = Category::query()->where('parent_id', 0)->get();
        // dd($categories[0]->childrenRecursive);

        return view('admin.products.create', compact('categories'));
    }
    public function store(StoreProductRequest $request)
    {
            try {
            DB::beginTransaction();

            $data = [
                'name' => $request->name,
                'slug' => $request->slug,
                'sku' => $request->sku,
                'price' => $request->price,
                'sale' => $request->sale ?? null , 
                'short_description' => $request->short_description ?? '',
                'long_description' => $request->long_description ?? '',
                'author' => $request->author,
                'publisher' => $request->publisher,
                'released' => $request->released,
                'weight' => $request->weight,
                'page'=>$request->page,
                'quantity' => $request->quantity,
                'best' => $request->best ?? 0,
                'active' => $request->active ?? 1,
                'order' => $request->order ?? 1,
    
            ];
    
            $data['image'] = StorageImageTrait::storageTraitUpload($request, 'image', 'products')['path']??'';
    
            // dd($request->categories);
            $product = Product::create( $data);
    
            foreach ($request->categories as $category) {
                $product -> ProductCategories() -> create(['category_id'=>$category]);
            }
            $product_images = StorageImageTrait::storageTraitUploadMultiple($request, 'product_image','products');
            // dd($product_images);
            if (is_array($product_images)){
                foreach ($product_images as $product_image) {
                    $product -> galleries() -> create(['image'=>$product_image['path']]);
                }
            }
            DB::commit();

            return redirect()->route( 'admin.product.index')->with('status_succeed','Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            // Roll back the transaction if anything fails
            DB::rollBack();

            // Log the error or display an error message
            Log::error($e->getMessage());
            return back()->with(['status_failed' => $e->getMessage()]);
        }

    }

}
