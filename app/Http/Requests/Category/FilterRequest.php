<?php

namespace App\Http\Requests\Category;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page' => 'numeric',
            'per_page' => 'numeric|min:5|max:30',
            'sort' => 'in:id,name,sort,updated_at',
        ];
    }
}
