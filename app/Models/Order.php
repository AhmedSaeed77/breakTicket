<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [ 'order_number' , 'from' , 'totalprice' , 'price_before_copoune' , 'is_adminAccepted' , 'is_userAccepted'  ,'payed' , 'copoune_id' , 'is_finished'];

    public function getIsAdminAcceptedAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->attributes['is_adminAccepted'] == 0 ? 'Not Accepted' : 'Accepted';
        }
        else
        {
            return $this->attributes['is_adminAccepted'] == 0 ? 'غير مقبول ' : 'مقبول';
        }
    }

    public function getIsFinishedAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->attributes['is_finished'] == 0 ? 'Not Finished' : 'Finished';
        }
        else
        {
            return $this->attributes['is_finished'] == 0 ? 'غير منتهى ' : 'منتهى';
        }
    }

    public function getPayedAttribute()
    {
        if(app()->getLocale()=='en')
        {
            return $this->attributes['payed'] == 0 ? 'Not Payed' : 'Payed';
        }
        else
        {
            return $this->attributes['payed'] == 0 ? 'غير مدفوع ' : 'مدفوع';
        }
    }

    public function getIsUserAcceptedAttribute()
    {
        if(app()->getLocale()=='en')
        {
            if($this->attributes['is_userAccepted'] == 0)
            {
                return 'In Progress';
            }
            elseif($this->attributes['is_userAccepted'] == 2)
            {
                return 'Accepted';
            }
            elseif($this->attributes['is_userAccepted'] == 1)
            {
                return 'Not Accepted';
            }
        }
        else
        {
            if($this->attributes['is_userAccepted'] == 0)
            {
                return 'قيد المعالجه';
            }
            elseif($this->attributes['is_userAccepted'] == 2)
            {
                return 'مقبول';
            }
            elseif($this->attributes['is_userAccepted'] == 1)
            {
                return 'غير مقبول';
            }
        }
    }

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class,'order_tickets');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'order_id');
    }

    public function copoune()
    {
        return $this->belongsTo(Copoune::class,'copoune_id');
    }

    public function order_tickets()
    {
        return $this->hasMany(OrderTicket::class,'order_id');
    }
}
