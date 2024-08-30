<?php

namespace App\Http\Requests\Feedback;

use App\Rules\CaptchaV3;
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
            'ip_address' => ['string'],
            'fio' => [ 'required', 'string', 'min:3', 'max:120', 'regex:/([а-яёa-z-]+)([а-яёa-z ]*)/i' ],
            "email" => [ 'required', 'string', 'email:rfc,dns', 'max:255' ],
            "phone" => [ 'required', 'string', 'regex:/\+([\d]) ([\d]{3}) ([\d]{4}) ([\d]{3})/i' ],
            "comment" => ['string', 'max:2000'],
            'g-recaptcha-response' => ['required', new CaptchaV3('feedbackCaptcha', 0.5)]
        ];
    }
    
    public function messages(){
        return [
            'phone.regex' => 'Поле не прошло валидацию'
        ];
    }

}
