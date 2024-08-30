<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\CaptchaV3;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fio' => [ 'required', 'string', 'min:3', 'max:120', 'regex:/([а-яёa-z-]+)([а-яёa-z ]*)/i' ],
            'email' => ['required', 'string', 'email', 'max:70', 'unique:users', 'regex:/[\w\d]+@[\w\d]+\.[\w\d]+/i'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => ['required', new CaptchaV3('registrCaptcha', 0.5)]
        ],
        [
            'password.confirmed' => 'Подтверждение пароля не прошло проверку',
            'password.min' => 'Введите не менее 8 символов',
            'email.unique' => 'Пользователь с таким email уже зарегистрирован',
            'email.regex' => 'Ваш email не прошел валидацию'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'fio' => $data['fio'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
