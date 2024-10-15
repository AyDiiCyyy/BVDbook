<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $guarded = [];

    public function galleries () {
        return $this->hasMany(ProductGallery::class,'product_id','id');
    }

    public function ProductCategories (){
        return $this->hasMany(CategoryProduct::class,'product_id','id');
    }
     
    public function OrderDetails (){
        return $this->hasMany(CategoryProduct::class,'product_id','id');
    }
    
    public function Carts (){
        return $this->hasMany(Cart::class,'product_id','id');
    }

    public function Comments (){
        return $this->hasMany(Comment::class,'product_id','id');
    }
    
}
