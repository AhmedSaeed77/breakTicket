<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartReturnResource extends JsonResource
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
                    'ticket_id' => $this->ticket_id,
                    'newprice' => $this->newprice,
                    'event_name' => $this->event->name,
                    'event_place' => $this->event->place,
                    'event_belong' => $this->event->belong,
                    'event_date' => $this->event->event_date,
                    'event_time' => $this->event->event_time,
                    'event_image' => $this->event->image,
                    'event_image_blog' => $this->event->blogimage,
                    // 'event' => $this->event,
                    // 'user' => $this->user,
                    // 'box' => $this->box,
                    // 'subcategory' => $this->subcategory,
//                    'box_name' => $this->box->name,
                    'subcategory_name' => $this->subcategory->name,
                    'location' => $this->loaction,
                    'row' => $this->row,
                    'counter' => $this->counter,
                    'ticket' => $this->ticket->tickests_Info,
                    'cat_info' => $this->cart_info,
                ];
    }

}
