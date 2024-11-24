<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AdminTicketRequest extends FormRequest
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
                    'event_id' => 'required',
//                    'box_id' => 'required',
                    //'subcategory_id	' => 'required',
                    'price' => 'required',
                    'quantity' => 'required',
                    //'is_adjacent' => 'required',
                    //'is_direct_sale' => 'required',
                ];
    }
}
