<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
                    'slug' => $this->slug,
                    'name' => $this->name,
                    'place' => $this->place,
                    'belong' => $this->belong,
                    'event_date' => $this->event_date,
                    'event_time' => $this->event_time,
                    'is_popular' => $this->is_popular,
                    'is_active' => $this->is_active,
                    'image' => $this->image,
                    'coverimage' => $this->coverimage,
                    'event_image_blog' => $this->blogimage,
                    //'boxes' => $this->boxes,
                    //'subcategories' => $this->subcategories,
                    //'tickets' => $this->tickets,
                ];
    }
}
