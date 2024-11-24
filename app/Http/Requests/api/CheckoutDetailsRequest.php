<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutDetailsRequest  extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                    'order_transaction_token' => 'required',
                    'order_id'=>'required|exists:orders,id',
                    'type' => 'required|in:1,2,3',
                ];
    }
}
