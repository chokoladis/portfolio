<?php

namespace App\Http\Requests\ExampleWork;

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
            'work' => 'string',
            'profile' => 'string',
            'created_at_from' => 'date|before_or_equal:yesterday',
            'created_at_to' => 'date|after_or_equal:created_at_from',
        ];
    }
}
