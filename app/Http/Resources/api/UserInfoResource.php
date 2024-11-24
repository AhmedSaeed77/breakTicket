<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
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
                    'name' => $this->name,
                    'maile' => $this->email,
                    'my_tickets' => $this->tickets->count(),
                    'new_request' => $this->newordercount,
                    'my_sales' => $this->sallescount,
                    'my_wallet' => $this->wallet,
                ];
    }
}
