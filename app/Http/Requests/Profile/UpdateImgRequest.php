<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateImgRequest extends FormRequest
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
            'url_avatar' => ['required', 'mimes:jpg,png,jpeg,gif',
                            File::image()
                                ->max(3 * 1024)]
        ];
    }

    public function messages(){
        return [
            'url_avatar.size' => 'Размер изображения более 3мб'
        ];
    }
}
