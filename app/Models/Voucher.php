<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Voucher extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'vouchers';

    protected $guarded = [];

    protected $fillable = [
        'name',
        'sku',
        'discount_amount',
        'min_order_amount',
        'usage_limit',
        'description',
        'start',
        'end',
        'status',
        'role'

    ];

    public function UserVouchers (){
        return $this->hasMany(UserVoucher::class,'voucher_id','id');
    }

    
}
