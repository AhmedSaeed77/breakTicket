<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded = [];

    public function getImageAttribute($value)
    {
        return url($value);
    }

    public function getNameAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->name_en??$this->name_ar;
        }
        else
        {
            return $this->name_ar;
        } 
    }

    public function events()
    {
        return $this->hasMany(Event::class,'cat_id');
    }
}
