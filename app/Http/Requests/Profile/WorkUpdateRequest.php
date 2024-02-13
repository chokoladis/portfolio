<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class WorkUpdateRequest extends FormRequest
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
        $rules = [
            'title' => 'string',
            'description' => 'string',
            'url_work' => 'string',
            'url_files' => 'array|nullable',
            'url_files.*' => 'string',
            'url_files_flags' => 'array|nullable',
            'url_files_flags.*' => 'accepted',
        ];

        if ($this->input('photo')){
            $photos = count($this->input('photo'));
            foreach(range(0, $photos) as $index) {
                $rules['photo.' . $index] = [File::types(['jpeg','jpg','png','gif', 'svg', 'bmp'])->max(3 * 1024)];
            }
        }
        

        return $rules;
    }

}
