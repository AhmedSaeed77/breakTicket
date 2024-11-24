<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBankInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
                    'Account_Number' => $this->accountnumber,
                    'IBAN_Number' => $this->ibannumber,
                    'Bank_Name' => $this->bankname,
                    'Account_Name' => $this->accountname,
                ];
    }
}
