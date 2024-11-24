<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserOneSalledResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return
        [
            'id' => $this->id,
            'event_name' => $this->event->name,
            'event_place' => $this->event->place,
            'event_belong' => $this->event->belong,
            'event_date' => $this->event->event_date,
            'event_time' => $this->event->event_time,
            'subcategory_name' => $this->subcategory_name,
        //    'totalprice' => $this->order->totalprice,
            'totalprice' => $this->summoney,
            'details' => $this->ticket_info,
        ];
    }
}
