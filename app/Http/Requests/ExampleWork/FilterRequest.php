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
            'page' => 'numeric',
            'per_page' => 'numeric|min:5|max:20',
            'work' => 'string|nullable',
            'profile' => 'string|nullable',
            'created_at_from' => 'date|before_or_equal:yesterday',
            'created_at_to' => 'date|after_or_equal:created_at_from',
            'show_deleted' => 'boolean',
        ];
    }

    /**
     * Prepare inputs for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'show_deleted' => $this->toBoolean($this->show_deleted),
        ]);
    }

    /**
     * Convert to boolean
     *
     * @param $booleable
     * @return boolean
     */
    private function toBoolean($booleable)
    {
        return filter_var($booleable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
