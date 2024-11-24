<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
                    'price' => 'required|numeric|gt:0',
                    'quantity' => 'required|numeric|gt:0',
                    'is_adjacent' => 'required',
                    'is_direct_sale' => 'required',
                    'info' => 'required|array',
                    // 'info.*.image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:4096',
                    'info.*.image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:4194304', // 4 GB in kilobytes
                    'info.*.chair_number' => 'required',
                    'info.*.row' => 'required',

                    // 'flag' => 'required|in:0,1',
                    // 'event_id' => 'required_if:flag,0',
                    // 'box_id' => 'required_if:flag,0',
                    // 'event_name' => 'required_if:flag,1',
                    // 'box_name' => 'required_if:flag,1',
                    // 'subcategory_name' => 'required_if:flag,1',
                    // 'price' => 'required',
                    // 'quantity' => 'required',
                    // 'is_adjacent' => 'required',
                    // 'is_direct_sale' => 'required',
                ];
    }
}
