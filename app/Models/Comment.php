<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'comments';
    protected $guarded = [];

    public function Product (){
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function User (){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
