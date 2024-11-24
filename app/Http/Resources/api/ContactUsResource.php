<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsResource extends JsonResource
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
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'snapchat' => $this->snapchat,
                    'youtube' => $this->youtube,
                    'fb' => $this->fb,
                    'tw' => $this->tw,
                    'linkedin' => $this->linkedin,
                    'whatsapp_phone' => $this->whatsapp_phone,
                    'inst' => $this->inst,
                ];
    }
}
