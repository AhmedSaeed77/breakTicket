<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTicketInfo extends Model
{
    use HasFactory;

    protected $table = 'order_ticket_infos';
    protected $guarded = [];

    public function order_ticket()
    {
        return $this->belongsTo(OrderTicket::class,'order_ticket_id'); 
    }
}
