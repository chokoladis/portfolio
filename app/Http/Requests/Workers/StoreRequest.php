<?php

namespace App\Http\Requests\Workers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => '',
            'url_avatar' => 'string|nullable',
            'phone' => 'required|string|min:17',
            'about' => 'string|nullable',
            "socials"    => "array|nullable",
            "socials.*"  => "string|nullable",
        ];
    }

    public function messages(){
        return [
            'phone.min' => 'Поле телефон не заполнено полностью'
        ];
    }
}
