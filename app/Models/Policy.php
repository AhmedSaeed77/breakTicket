<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $table = 'policies';
    protected $guarded = [];

    public function getTitleAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->title_en;
        }
        else
        {
            return $this->title_ar;
        } 
    }

    public function getDescriptionAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->description_en;
        }
        else
        {
            return $this->description_ar;
        } 
    }
}
