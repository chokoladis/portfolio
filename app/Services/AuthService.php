<?php

namespace App\Services;

use App\Mail\ServiceAuthMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthService
{
    const YANDEX_LINK_PICTURE = 'https://avatars.mds.yandex.net/get-yapic/';

    public function googleAuth(Request $request){

        $code = urldecode($request->get('code'));

        if (!empty($code)) {

            if ($data = $this->getGoogleUserToken($code)){

                $userData = $this->getGoogleUserInfo($data);

                $user = User::query()
                    ->where('email', $userData['email'])
                    ->first();

                if (!$user){
                    $profilePhoto = isset($userData['picture']) ? $userData['picture'] : '';

                    $password = str()->random(10);
                    $passwordHased = Hash::make($password);

                    $newUser = User::create([
                        'fio' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => $passwordHased,
                        'active' => 1,
                        'profile_photo_path' => $profilePhoto,
                    ]);

                    $user = $newUser;
                    
                    Mail::to($userData['email'])
                        ->send(new ServiceAuthMail($user));
                }

                Auth::login($user);

            } else {
                exit;
            }

        } else {
            throw new Exception("Ошибка параметров");
        }

        return redirect()->route('home');
    }

    public function getGoogleUserToken(string $code){

        try {
            $params = array(
                'client_id'     => config('auth.socials.google.client_id'),
                'client_secret' => config('auth.socials.google.client_secret'),
                'redirect_uri'  => config('auth.socials.google.redirect_uri'),
                'grant_type'    => 'authorization_code',
                'code'          => $code
            );
                    
            $ch = curl_init('https://accounts.google.com/o/oauth2/token');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $data = curl_exec($ch);
            curl_close($ch);
        
            $data = json_decode($data, true);
            
            if (!empty($data['access_token'])){
                return $data;
            } elseif (isset($data['error']) && !empty($data['error'])) {
                echo 'error -> '.$data['error'];
            } else {
                echo 'Неизвестная ошибка<br>';
                print_r($data);
            }

        } catch (\Throwable $th) {
            throw $th;
        }

        return false;
    }

    public function getGoogleUserInfo(array $data){

        $params = array(
            'access_token' => $data['access_token'],
            'id_token'     => $data['id_token'],
            'token_type'   => 'Bearer',
            'expires_in'   => 3599
        );

        $info = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?' . urldecode(http_build_query($params)));
        $info = json_decode($info, true);

        return $info;
    }
    
    public function yandexAuth(Request $request){

        $code = urldecode($request->get('code'));
        
        if (!empty($code)) {
            
            if ($data = $this->getYandexUserToken($code)){

                $userData = $this->getYandexUserInfo($data);

                $user = User::query()
                    ->where('email', $userData['default_email'])
                    ->first();

                if (!$user){

                    $profilePhoto = isset($userData['default_avatar_id']) ? self::YANDEX_LINK_PICTURE.$userData['default_avatar_id'] : '';

                    $password = str()->random(10);
                    $passwordHased = Hash::make($password);

                    $newUser = User::create([
                        'fio' => $userData['real_name'],
                        'email' => $userData['default_email'],
                        'password' => $passwordHased,
                        'active' => 1,
                        'profile_photo_path' => $profilePhoto,
                    ]);

                    $user = $newUser;

                    Mail::to($userData['default_email'])
                        ->send(new ServiceAuthMail($user));
                }

                Auth::login($user);
            
            } else {
                exit;
            }

        } else {
            throw new Exception("Ошибка параметров");
        }

        return redirect()->route('home');
    }

    public function getYandexUserToken(string $code){

        try {

            $fields = array(
                'grant_type'    => 'authorization_code',
                'code'          => $code,
                'client_id'     => config('auth.socials.yandex.client_id'),
                'client_secret' => config('auth.socials.yandex.client_secret'),
            );
            
            $ch = curl_init('https://oauth.yandex.ru/token');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $data = curl_exec($ch);
            curl_close($ch); 
                    
            $data = json_decode($data, true);

            if (!empty($data['access_token'])){
                return $data;
            } elseif (isset($data['error']) && !empty($data['error'])) {
                echo 'error -> '.$data['error'];
            } else {
                echo 'Неизвестная ошибка<br>';
                print_r($data);
            }

        } catch (\Throwable $th) {
            throw $th;
        }

        return false;
    }

    public function getYandexUserInfo(array $data){
        
        $ch = curl_init('https://login.yandex.ru/info');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('format' => 'json')); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $data['access_token']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $info = curl_exec($ch);
        curl_close($ch);

        $info = json_decode($info, true);
        return $info;
    }
}