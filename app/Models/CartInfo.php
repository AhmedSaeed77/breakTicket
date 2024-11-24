<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartInfo extends Model
{
    use HasFactory;

    protected $table = 'cart_infos';
    protected $guarded = [];

    public function cart()
    {
        return $this->belongsTo(Cart::class,'cart_id');
    }
}
