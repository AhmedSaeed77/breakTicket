<?php

namespace App\Http\Resources\api;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserNewOrderResource extends JsonResource
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
            'order_id' => $this->order->id,
            'ticket_order_id' => $this->id,
            'event_name' => $this->event->name,
            'order_number' => $this->order->order_number,
//            'box_name' => $this->box_name,
            'subcategory_name' => $this->subcategory_name,
//            'price' => $this->newprice,
            'price' => $this->summoney,
            'date' => Carbon::parse($this->order->created_at)->format('Y-m-d'),
            'quantity' => $this->quantity,
            'order_ticket_infos' => $this->order_ticket_infos,
        ];
    }
}
