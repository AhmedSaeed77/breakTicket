<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AdminTicketInfoRequest extends FormRequest
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
        if ($this->isMethod('post'))
        {
            return [
                        'row' => 'required',
                        'chair_number' => 'required',
                        'image'=>'required|mimes:jpeg,png,jpg,gif,svg|max:4096',
                    ];
        }
        if ($this->isMethod('put'))
        {
            return [
                        'row' => 'required',
                        'chair_number' => 'required',
                ];
        }
    }
}
