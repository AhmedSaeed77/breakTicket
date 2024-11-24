<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
                    'name_en' => 'required|max:255',
                    'name_ar' => 'required|max:255',
                    'address_en' => 'required|max:255',
                    'address_ar' => 'required|max:255',
                    'email' => 'required|max:255',
                    'phone' => 'required|max:255',
                    'whatsapp_phone' => 'required',
                    'inst' => 'required',
                    'tw' => 'required',
                    'fb' => 'required',
                    'linkedin' => 'required',
                    'message_en' => 'required',
                    'message_ar' => 'required',
                    'vision_en' => 'required',
                    'vision_ar' => 'required',
                    'about_en' => 'required',
                    'about_ar' => 'required',
                    'youtube' => 'required',
                    'snapchat' => 'required',
                    'tiktok' => 'required',
                ];
    }
}
