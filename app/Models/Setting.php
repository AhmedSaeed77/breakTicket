<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $guarded = [];

    public function getHomeCoverAttribute($value)
    {
        return url($value);
    }

    public function getSiteLogoAttribute($value)
    {
        return url($value);
    }

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

    public function getAddressAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->address_en;
        }
        else
        {
            return $this->address_ar;
        } 
    }

    public function getMessageAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->message_en;
        }
        else
        {
            return $this->message_ar;
        } 
    }

    public function getVisionAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->vision_en;
        }
        else
        {
            return $this->vision_ar;
        } 
    }

    public function getAboutAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->about_en;
        }
        else
        {
            return $this->about_ar;
        } 
    }
}
