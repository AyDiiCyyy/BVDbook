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

    public function UserVouchers (){
        return $this->hasMany(UserVoucher::class,'voucher_id','id');
    }
}
