<?php

namespace App\Http\Resources\api;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
                    'id' => $this->id,
                    'status' => $this->is_accepted,
                    'event_id' => $this->event->id,
                    'event_name' => $this->event->name,
                    'event_place' => $this->event->place,
                    'event_belong' => $this->event->belong,
                    'event_date' => $this->event->event_date,
                    'event_time' => $this->event->event_time,
                    // 'box' => $this->box,
//                    'box_name' => $this->box->name,
                    'subcategory_name' => $this->subcategory->name,
                    'quantity' => $this->quantity,
                    'price' => $this->price,
                    'ticket_salled' => $this->ticket_salled,
                    'ticket_not_salled' => $this->ticket_not_salled,
                    'date' => Carbon::parse($this->created_at)->format('Y-m-d'),
                ];
    }
}
