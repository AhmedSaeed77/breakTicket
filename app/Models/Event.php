<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
//    protected $guarded = [];

    protected $fillable = [
                                'slug_ar' , 'slug_en' , 'name_en' ,
                                'name_ar' , 'place_en'  ,
                                'place_ar' , 'belong_ar' , 'belong_en',
                                'event_date' , 'event_time', 'commission',
                                'image' , 'coverimage', 'blogimage',
                                'cat_id' , 'is_popular' , 'is_active',
                            ];
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

    public function getSlugAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->slug_en;
        }
        else
        {
            return $this->slug_ar;
        }
    }

    public function getPlaceAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->place_en;
        }
        else
        {
            return $this->place_ar;
        }
    }

    public function getBelongAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->belong_en;
        }
        else
        {
            return $this->belong_ar;
        }
    }

    public function getImageAttribute($value)
    {
        return url($value);
    }

    public function getCoverImageAttribute($value)
    {
        return url($value);
    }

    public function getBlogImageAttribute($value)
    {
        return url($value);
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'cat_id');
    }

    public function boxes()
    {
        return $this->hasMany(Box::class,'event_id');
    }

    public function subcategories()
    {
        return $this->hasMany(subcategory::class,'event_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class,'event_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class,'event_id');
    }

    public function copounes()
    {
        return $this->belongsToMany(Copoune::class,'copoune_events');
    }

}
