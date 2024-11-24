<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
                    'user_name' => $this->user->name,
                    'event_name' => $this->event->name_en,
//                    'box_name' => $this->box->name_en,
                    'subcategory_name' => $this->subcategory->name_en,
                    'counter' => $this->counter,
                ];
    }
}
