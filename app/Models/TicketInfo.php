<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketInfo extends Model
{
    use HasFactory;

    protected $table = 'ticket_infos';
    protected $guarded = [];

    protected $hidden = ['created_at','updated_at'];

    public function getImageAttribute($value)
    {
        return url($value);
    }

    public function getChairNumberAttribute($value)
    {
        if(app()->getLocale() == 'ar')
        {
            if ($value == 'undefined')
            {
                return 'غير محدد';
            }
        }
        return $value;
    }

    public function getRowAttribute($value)
    {
        if(app()->getLocale() == 'ar')
        {
            if ($value == 'undefined')
            {
                return 'غير محدد';
            }
        }
        return $value;
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }
}
