<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $guarded = [];
    // protected $fillable = [
    //                         'event_id','box_id',
    //                         'subcategory_id','price',
    //                         'quantity','is_adjacent',
    //                         'is_direct_sale','user_id',
    //                         'admin_id','is_accepted',
    //                         'is_selled','totalprice'
    //                     ];

    public function getIsSelledAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->attributes['is_selled'] == 0 ? 'Not Salled' : 'Salled';
        }
        else
        {
            return $this->attributes['is_selled'] == 0 ? 'غير مباعه' : 'مباعه';
        }

    }
    public function getIsAcceptedAttribute()
    {
        if(app()->getLocale()=='en')
        {
            if($this->attributes['is_accepted'] == 0)
                return "In Progress";
            elseif($this->attributes['is_accepted'] == 1)
                return 'Not Accepted';
            elseif($this->attributes['is_accepted'] == 2)
                return 'Accepted';
            elseif($this->attributes['is_accepted'] == 3)
                return 'Salled';
        }
        else
        {
            if($this->attributes['is_accepted'] == 0)
                return "قيد المعالجة";
            elseif($this->attributes['is_accepted'] == 1)
                return 'مرفوضة';
            elseif($this->attributes['is_accepted'] == 2)
                return 'مقبولة';
            elseif($this->attributes['is_accepted'] == 3)
                return 'مباعة';
        }

    }

    public function getIsAdjacentAttribute()
    {
        if(app()->getLocale()=='en')
        {
            if($this->attributes['is_adjacent'] == 1)
                return "Adjacent";
            elseif($this->attributes['is_adjacent'] == 0)
                return 'Not Adjacent';
        }
        else
        {
            if($this->attributes['is_adjacent'] == 1)
                return "متجاوره";
            elseif($this->attributes['is_adjacent'] == 0)
                return 'غير متجاوره';
        }

    }

    public function getIsDirectSaleAttribute()
    {
        if(app()->getLocale()=='en')
        {
            if($this->attributes['is_direct_sale'] == 1)
                return "Direct Sale";
            elseif($this->attributes['is_direct_sale'] == 0)
                return 'Not Direct Sale';
        }
        else
        {
            if($this->attributes['is_direct_sale'] == 1)
                return "بيع مباشر";
            elseif($this->attributes['is_direct_sale'] == 0)
                return 'بيع غير مباشر';
        }
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id');
    }

    public function box()
    {
        return $this->belongsTo(Box::class,'box_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(subcategory::class,'subcategory_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function tickests_Info()
    {
        return $this->hasMany(TicketInfo::class,'ticket_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class,'ticket_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_tickets');
    }
}
