<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'orders';
    protected $guarded = [];

    public function OrderDetails (){
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }
    public function Voucher (){
        return $this->belongsTo(Voucher::class,'voucher_id','id');
    }
    public function User (){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
