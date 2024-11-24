<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilterResource extends JsonResource
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
//                    'location' => $this->location->chair_number??'',
                    'location' => $this->location->name,
                    'event_id' => $this->event_id,
                    'box_id' => $this->box_id,
                    'subcategory_id' => $this->subcategory_id,
                    'event_name' => $this->event->name,
//                    'box_name' => $this->box->name,
                    'subcategory_name' => $this->subcategory->name,
                    'totalprice' => $this->totalprice,
                    'countersalled' => $this->quantity,
                    'salled' => $this->salled,
                    'quantity' => $this->counter,
                    'is_accepted' => $this->is_accepted,
                    'is_selled' => $this->is_selled,
                    'is_adjacent' => $this->is_adjacent,
                    'is_direct_sale' => $this->is_direct_sale,
                    'tickests_info' => $this->tickests_Info
                ];
    }
}
