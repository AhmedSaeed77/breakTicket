<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
                'name_en' => 'required|max:255',
                'name_ar' => 'required|max:255',
                'place_en' => 'required|max:255',
                'place_ar' => 'required|max:255',
                'belong_en' => 'required|max:255',
                'belong_ar' => 'required|max:255',
                'event_date' => 'required',
                'event_time' => 'required',
                'commission' => 'required',
                'cat_id' => 'required',
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:4096',
                'coverimage' => 'required|mimes:jpeg,png,jpg,gif,svg|max:4096',
                'blogimage' => 'required|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ];
        }
        if ($this->isMethod('put'))
        {
            return [
                'name_en' => 'required|max:255',
                'name_ar' => 'required|max:255',
                'place_en' => 'required|max:255',
                'place_ar' => 'required|max:255',
                'belong_en' => 'required|max:255',
                'belong_ar' => 'required|max:255',
                'event_date' => 'required',
                'event_time' => 'required',
                'commission' => 'required',
                'cat_id' => 'required',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:4096',
                'coverimage' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:4096',
                'blogimage' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:4096',
            ];
        }
    }
}
