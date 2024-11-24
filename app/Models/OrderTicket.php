<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTicket extends Model
{
    use HasFactory;

    protected $table = 'order_tickets';
    protected $fillable = [ 'event_id' , 'ticket_id' , 'order_id' , 'quantity' , 'newprice' , 'from_user' , 'to_user' , 'is_convert' ];

    public function getIsConvertAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->attributes['is_convert'] == 0 ? 'Not Converted' : 'Converted';
        }
        else
        {
            return $this->attributes['is_convert'] == 0 ? 'لم يتم التحويل بعد' : 'تم التحويل';
        }
    }
    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function order_ticket_infos()
    {
        return $this->hasMany(OrderTicketInfo::class,'order_ticket_id');
    }
}
