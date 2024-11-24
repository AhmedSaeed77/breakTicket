<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }

    public function box()
    {
        return $this->belongsTo(Box::class,'box_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(subcategory::class,'subcategory_id');
    }

    public function cart_info()
    {
        return $this->hasMany(CartInfo::class,'cart_id');
    }
}
