<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserVoucher extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'user_vouchers';
    protected $guarded = [];

    public function Voucher (){
        return $this->belongsTo(Voucher::class,'voucher_id','id');
    }
    public function User (){
        return $this->belongsTo(User::class,'User_id','id');
    }
}
