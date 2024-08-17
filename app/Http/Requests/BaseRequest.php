<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
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
    public function messages(){
        return [
            'validation.min' => 'Зполнено не достаточно',
            'validation.max' => 'Имеет слишком большое значение',
            'validation.required' => 'Обязательно к заполнению',
            'validation.regex' => 'Не прошло валидацию',
        ];
    }
}
