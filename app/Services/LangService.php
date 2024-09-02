<?php

namespace App\Services;

use Illuminate\Http\Request;

class LangService{

    const ALLOWS = [ 'ru', 'en' ];
    
    public function setLang(Request $request){

        // $lang = $request->get('lang');
        $data = $request->validate(['lang' => 'required|string|min:2|max:2']);
        dump($data);
        
        if (in_array($data['lang'], self::ALLOWS)){
            
        }
    }
}