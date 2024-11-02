<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'categories';
    protected $guarded = [];

    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id'); 
        // mối quan hệ 1 nhiều từ bảng danh mục
        // danh mục có id là 1 nối vs bảng nhiều chính là bảng danh mục khóa phụ là parent_id 
        // sẽ có nhiều trường dữ liệu parent_id liên kết vs trường dữ liệu id
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
        // nghịch đảo của 1 nhiều
    }
    public function CategoryProducts()
    {
        return $this->hasMany(CategoryProduct::class, 'category_id', 'id');
        // mối quan hệ 1 nhiều với bảng sản phẩm
    }

    // Hàm đệ quy để lấy tất cả các mục con
    public function childrenRecursive()
    {
        return $this->childs()->with('childrenRecursive');
    }
    public function descendants(): Collection
    {
        $descendants = new Collection(); // Sử dụng Eloquent Collection
    
        $getChildren = function ($category) use (&$getChildren, &$descendants) {
            foreach ($category->childs as $child) {
                $descendants->push($child);
                $getChildren($child);
            }
        };
    
        $getChildren($this);
        return $descendants;
    }
}