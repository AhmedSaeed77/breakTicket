<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FooterResource extends JsonResource
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
                    'homecover' => $this->homecover,
                    'sitelogo' => $this->sitelogo,
                    'twiter' => $this->tw,
                    'instagram' => $this->inst,
                    'tiktok' => $this->tiktok,
                    'whatsapp' => $this->whatsapp_phone,
                ];
    }
}
