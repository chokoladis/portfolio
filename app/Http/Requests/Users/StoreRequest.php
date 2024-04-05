<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

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
            'fio' => [ 'required', 'string', 'min:3', 'max:120', 'regex:/([а-яёa-z-]+)([а-яёa-z ]*)/i' ],
            'email' => ['required', 'string', 'email', 'max:70', 'unique:users', 'regex:/[\w\d]+@[\w\d]+\.[\w\d]+/i'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(){
        return [
            'password.confirmed' => 'Подтверждение пароля не прошло проверку',
            'password.min' => 'Введите не менее 8 символов',
            'email.unique' => 'Пользователь с таким email уже зарегистрирован',
            'email.regex' => 'Ваш email не прошел валидацию'
        ];
    }
}
