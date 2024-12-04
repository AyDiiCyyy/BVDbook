<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'carts';
    protected $guarded = [];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function Users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
