<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
                'sale' => $request->sale ?? null,
                'short_description' => $request->short_description ?? '',
                'long_description' => $request->long_description ?? '',
                'author' => $request->author,
                'publisher' => $request->publisher,
                'released' => $request->released,
                'weight' => $request->weight,
                'page' => $request->page,
                'quantity' => $request->quantity,
                'best' => $request->best ?? 0,
                'active' => $request->active ?? 0,
                'order' => $request->order ?? 1,

            ];

            $data['image'] = StorageImageTrait::storageTraitUpload($request, 'image', 'products')['path'] ?? '';
            // dd($data);
            // dd($request->categories);
            $product = Product::create($data);

            foreach ($request->categories as $category) {
                $product->ProductCategories()->create(['category_id' => $category]);
            }
            $product_images = StorageImageTrait::storageTraitUploadMultiple($request, 'product_image', 'products');
            // dd($product_images);
            if (is_array($product_images)) {
                foreach ($product_images as $product_image) {
                    $product->galleries()->create(['image' => $product_image['path']]);
                }
            }
            DB::commit();

            return redirect()->route('admin.product.index')->with('status_succeed', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            // Roll back the transaction if anything fails
            DB::rollBack();

            // Log the error or display an error message
            Log::error($e->getMessage());
            return back()->with(['status_failed' => $e->getMessage()]);
        }
    }
    public function edit($id)
    {
        $product = Product::query()->findOrFail($id);
        $categories = Category::query()->where('parent_id', 0)->get();
        $selectedCategories = $product->ProductCategories()->pluck('category_id')->toArray(); 
    
        return view('admin.products.edit', compact('product', 'categories','selectedCategories'));
    }
    public function update(UpdateProductRequest $request, $id)
    {
        
        $product = Product::query()->findOrFail($id);
        try {

            DB::beginTransaction();

            $data = [
                'name' => $request->name,
                'slug' => $request->slug,
                'sku' => $request->sku,
                'price' => $request->price,
                'sale' => $request->sale ?? null,
                'short_description' => $request->short_description ?? '',
                'long_description' => $request->long_description ?? '',
                'author' => $request->author,
                'publisher' => $request->publisher,
                'released' => $request->released,
                'weight' => $request->weight,
                'page' => $request->page,
                'quantity' => $request->quantity,
                'best' => $request->best ?? 0,
                'active' => $request->active ?? 0,
                'order' => $request->order ?? 1,

            ];

            $data['image'] = StorageImageTrait::storageTraitUpload($request, 'image', 'products')['path'] ?? $product->image;
            // dd($data);
            if($request->hasFile('image')){
                $path = 'public/products/' . basename($product->image);
                if(Storage::exists($path)){
                    Storage::delete($path);
                } 
            }
            $product->update($data);
            //Handle Category 
           
            if ($request->categories) {
                 //lấy giá trị cột 'category_id' mà sản phẩm đấy có  biến thành mảng
                $getCategoryID = $product->ProductCategories()->pluck('category_id')->toArray();  
                //array_diff so sánh 2 mảng nó trả về cái khác nhau
                 $categoriesToDelete = array_diff(  $getCategoryID, $request->categories);
                // Xóa mềm các danh mục không có trong request
                    //WhereIN ('column',[Value 1,....]);
                    if (!empty($categoriesToDelete)) {
                        $product->ProductCategories()->whereIn('category_id', $categoriesToDelete)->delete();
                    }
                
                foreach ($request->categories as $category) {
                    //Lấy những danh mục trong CategoryProduct 'category_id' bị xóa mềm 
                    $trashedCategory = $product->ProductCategories()->withTrashed()->where('category_id', $category)->first();
                    if ($trashedCategory) {
                        //Có - Khôi phục
                        $trashedCategory->restore();
                    } else {
                        //Không - Tạo mới
                        $product->ProductCategories()->create(
                            ['category_id' => $category],
                            ['product_id' => $product->id]
                        );
                    }
                }
            }
            //Handle Product galleries
            $product_images = StorageImageTrait::storageTraitUploadMultiple($request, 'product_image', 'products');
            // dd($product_images);
            //Thêm hình ảnh ProductGallery

            if ($request->product_image) {
                if (is_array($product_images)) {
                    foreach ($product->galleries as $gallery) {
                        //Xóa cứng  
                        $path = 'public/products/' . basename($gallery->image);
                        // dd($path);
                        if($gallery && Storage::exists($path)){
                            Storage::delete($path);
                        }
                        $gallery->forceDelete();
                    }
                    foreach ($product_images as $product_image) {
                        $product->galleries()->create(['image' => $product_image['path']]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('admin.product.index')->with('status_succeed', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            // Roll back the transaction if anything fails
            DB::rollBack();

            // Log the error or display an error message
            Log::error($e->getMessage());
            return back()->with(['status_failed' => $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        $product = Product::query()->findOrFail($id);
        CategoryProduct::where('product_id', $product->id)->delete();
        $product->delete();
        return redirect()->route('admin.product.index')->with('status_succeed', 'Xóa sản phẩm thành công');
    }
}
