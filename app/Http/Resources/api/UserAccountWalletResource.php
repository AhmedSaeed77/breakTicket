<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAccountWalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
                    'name' => $this->name ?? '',
                    'account_number' => $this->account_number ?? @lang('site.No_Data'),
                    'wallet' => $this->wallet ?? 0,
                ];
    }
}
