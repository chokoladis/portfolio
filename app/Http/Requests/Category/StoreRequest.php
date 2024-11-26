<?php

namespace App\Http\Requests\Category;

use App\Services\FileService;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'entity_code' => 'required|string|min:4|max:30',
            'parent_id' => 'integer',
            'name' => 'required|string|min:2|max:30',
            'code' => 'required|string|min:2|max:30',
            'sort' => 'integer|nullable',
            'active' => 'boolean',
            'preview' => [
                'nullable',
                'mimes:jpg,png,jpeg,gif',
                File::image()
                    ->max(FileService::ACCEPT_FILE_SIZE),
            ] , //convert to preview_id
        ];
    }
}
