<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $guarded = [];

    public function getImageAttribute($value)
    {
        if($this->attributes['type'] == 0)
        {
            return url($value);
        }
        return $value;
    }

    public function getIsAcceptedAttribute()
    {
        if(app()->getLocale()=='en')
        {
            if($this->attributes['is_accepted'] == 0)
                return 'Not Payed';
            elseif($this->attributes['is_accepted'] == 1)
                return 'Payed';
        }
        else
        {
            if($this->attributes['is_accepted'] == 0)
                return 'غير مدفوع';
            elseif($this->attributes['is_accepted'] == 1)
                return 'مدفوع';
        }
    }

    public function getTypeAttribute()
    {
        if(app()->getLocale()=='en')
        {
            if($this->attributes['type'] == 0)
                return 'Bank Payment';
            elseif($this->attributes['type'] == 1)
                return 'Credit Payment';
        }
        else
        {
            if($this->attributes['type'] == 0)
                return 'تحويل بنكى';
            elseif($this->attributes['type'] == 1)
                return 'دفع الكترونى';
        }
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
