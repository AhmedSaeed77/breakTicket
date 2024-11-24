<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
                    'type'          => 'required|in:0,1',
                    'image'         =>'required_if:type,0|mimes:jpeg,png,jpg,gif,svg|max:4096',
                    'order_id'      => 'required',
                    'price'         => 'required',
                    'name'          => 'required',
                    'accountnumber' => 'required',
                ];
    }
//    public function messages()
//    {
//        return [
//                    'image.required_if' => 'The image field is required when type is 0.',
//                    'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
//                ];
//    }

}
