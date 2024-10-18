<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        
        $title ="Danh sách danh mục";
        $query = Category::query();

        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        if ($request->has('parent_id') && !empty($request->parent_id)) {
            $query->where('parent_id', $request->parent_id);
        }
    
        $categories = $query->with('parent')->get();
        $allCategories = Category::all(); 
        return view('admin.categories.list', compact('title','categories','allCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('childrenRecursive')->where('parent_id', 0)->get();
        $title = "Thêm mới danh mục";
        return view('admin.categories.add', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
    
            // Xử lý hình ảnh
            $image = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/categories', $fileName, 'public');
                $image = $filePath;
            }
    
            // Lưu danh mục
            $category = Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->parent_id ?? 0,
                'image' => $image,
            ]);
    
            // Commit the transaction
            DB::commit();
    
            // Luôn trả về trang index với thông báo thành công
            return redirect()->route('admin.category.index')->with('status_succeed', "Thêm danh mục thành công");
        } catch (\Exception $e) {
            // Rollback nếu có lỗi
            DB::rollBack();
    
            // Log lỗi và trả về thông báo lỗi
            Log::error($e->getMessage());
            return back()->with(['status_failed' => $e->getMessage()]);
        }
    }
    
    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
     
        try {
            $category = Category::findOrFail($id);
            
            // Xóa mềm tất cả danh mục con đệ quy
            $this->deleteCategoryWithChildren($category);
            
            // Xóa mềm danh mục cha
            $category->delete();
    
            // Trả về thông báo thành công
            return redirect()->route('admin.category.index')
                ->with('status_succeed', 'Xóa danh mục và các danh mục con thành công');
        } catch (\Exception $e) {
            // Ghi log lỗi và trả về thông báo thất bại
            Log::error($e->getMessage());
            return redirect()->route('admin.category.index')
                ->with('status_failed', 'Xóa danh mục không thành công do lỗi hệ thống');
        }
    }
    
    // Hàm đệ quy để xóa mềm danh mục và các danh mục con
    private function deleteCategoryWithChildren($category)
    {
        foreach ($category->childs as $child) {
            $this->deleteCategoryWithChildren($child);
            $child->delete();
        }
    }
}
