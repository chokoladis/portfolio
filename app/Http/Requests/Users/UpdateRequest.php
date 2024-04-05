<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:70', 'regex:/[\w\d]+@[\w\d]+\.[\w\d]+/i'], //'unique:users',
            'role' => [ 'required', 'string' ],
            'password' => ['required', 'string', Password::min(8)],
        ];
    }
}
