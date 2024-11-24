<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
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
                    'user' => $this->user??null,
                    'bank_name' => $this->bank_name??null,
                    'bank_account' => $this->bank_account??null,
                    'bank_iban' => $this->bank_iban??null,
                    'bank_swiftcode' => $this->bank_swiftcode??null,
                ];
    }
}
