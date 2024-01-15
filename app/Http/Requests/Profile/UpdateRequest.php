<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

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
            'phone' => 'required|regex:/\+([\d]) ([\d]{3}) ([\d]{4}) ([\d]{3})/i',
            'about' => 'string|nullable',
            "socials"    => "array|nullable",
            "socials.*"  => "string|nullable",
        ];
    }
}
