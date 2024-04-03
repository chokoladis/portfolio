<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'page' => 'numeric',
            'per_page' => 'numeric|min:5|max:20',
            'profile' => 'string|nullable',
            'created_at_from' => 'date|nullable|before_or_equal:yesterday',
            'created_at_to' => 'date|nullable|after_or_equal:created_at_from',
        ];
    }
}
