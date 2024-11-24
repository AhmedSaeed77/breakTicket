<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
                    'user' => 'required',
//                    'bank_name' => 'required|max:255',
                    //'bank_iban' => 'required|regex:/^[A-Za-z0-9]{24}$/',
                    'bank_swiftcode' => 'required|min:8|max:11',
                ];
    }
}
