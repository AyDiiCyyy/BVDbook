<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'order_details';
    protected $guarded = [];

    public function Order (){
        return $this->belongsTo(Order::class,'order_id','id');
    }
    public function Product (){
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
