<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
                    'event' => $this->event,
//                    'box' => $this->boxes,
                    'subcategory' => $this->subcategories,
                    'user' => $this->user->name,
                    'price' => $this->price,
                    'quantity' => $this->quantity,
                    'is_accepted' => $this->is_accepted,
                    'is_adjacent' => $this->is_adjacent,
                    'is_direct_sale' => $this->is_direct_sale,
                    'info' => $this->tickests_Info,
                ];
    }
}
