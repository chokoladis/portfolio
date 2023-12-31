<?php
    use App\Http\Controllers\HelperController;
?>
@extends('layouts.main')

@push('styles')
    @vite(['resources/scss/profile.scss'])
    @vite(['resources/scss/workers.scss'])
@endpush

@section('content')    
    <main>
        <div class="container">
            <section class="worker">
                @php
                    $worker['url_avatar'] = HelperController::$workerDirImg.$worker['url_avatar'];
                    $imgUrl = $worker['url_avatar'] && file_exists(public_path($worker['url_avatar'])) 
                        ? $worker['url_avatar'] : '/storage/general/user.png' ;

                    if ($worker['about']){
                        $f_about = true;
                        $textAbout = $worker['about'];
                    } else {
                        $f_about = false;
                        $textAbout = 'Пользователь не заполнил информацию о себе';
                    }

                    $phone = HelperController::phoneOutFormated($worker['phone']);

                @endphp
                <div class="small_info">
                    <div class="img">
                        <img src="{{ $imgUrl }}" alt="user avatar">
                    </div>
                    <div class="main_info">
                        <h3 class="name">{{ $worker['name'] }}</h3>
                        <div class="links">
                            <a href="tel:{{ $phone }}">
                                <div class="icon">
                                    <span uk-icon="icon:receiver" title="Позвонить"></span>
                                </div>
                                <span>{{ $phone }}</span>
                            </a>
                            <!-- какая то ещё небольшая инфа -->
                        </div>
                    </div>
                </div>
                <div class="big_info">
                    <p class="about {{ $f_about ? '' : 'is-disable' }}">{{ $textAbout }}</p>
                    @php 
                        if ($worker['socials'] !== null){
                            $arSocials = json_decode($worker['socials'], 1);

                            echo '<ul class="socials">';
                            foreach($arSocials as $socialKey => $link){
                                $link = htmlspecialchars($link);
                                $socialKey = htmlspecialchars($socialKey);
                                echo '<li class="'.$socialKey.'"><a href="'.$link.'" title="'.$link.'"></a></li>';
                            }
                            echo '</ul>';
                        }
                    @endphp
                </div>
            </section>
        </div>
    </main>

@endsection