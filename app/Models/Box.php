<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected $table = 'boxes';
    protected $guarded = [];

    public function getNameAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->name_en;
        }
        else
        {
            return $this->name_ar;
        } 
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'box_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class,'box_id');
    }

}
