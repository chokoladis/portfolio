<?php
    use App\Http\Controllers\HelperController;
?>
@extends('layouts.main')

@push('styles')
    @vite(['resources/scss/profile.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/profile.js'])
@endpush

@section('content')    
    <main>
        <div class="container">
            <section class="worker">
                @php
                    $url_avatar = HelperController::$workerDirImg.$worker->url_avatar;
                    $imgUrl = $worker->url_avatar && file_exists(public_path($url_avatar)) ? $url_avatar : '/storage/general/user.png' ;

                    if ($worker->about){
                        $f_about = true;
                        $textAbout = $worker->about;
                    } else {
                        $f_about = false;
                        $textAbout = 'Вы не заполнили информацию о себе';
                    }

                    $phone = HelperController::phoneOutFormated($worker->phone);

                @endphp
                <div class="small_info uk-width-1-4@m uk-width-1-1">
                    <form class="form_change_img" action='{{ route("profile.change_avatar") }}' method="POST">
                        <img src="{{ $imgUrl }}" alt="user avatar">
                        <div class="file_change">Изменить</div>
                        <input type="file" name="url_avatar" accept="image/*">
                        <input type="submit" value="Изменить">
                    </form>
                    <div class="main_info">
                        <h3 class="name">{{ $worker->name }}</h3>
                        <div class="links">
                            <a href="tel:{{ $phone }}">{{ $phone }}</a>
                            <a uk-toggle="target: #md-worker_edit" type="button">Редактировать профиль</button>
                            <a href="javascript:void(0)" class="js_profile_delete">Удалить профиль</a>
                            <!-- модалка вы точно хотите удалить профиль? вы больше не сможете просматривать профили других людей -->
                            <!-- какая то ещё небольшая инфа -->
                        </div>
                    </div>
                </div>
                <div class="big_info uk-width-3-4@m uk-width-1-1">
                    <p class="about {{ $f_about ? '' : 'is-disable' }}">{{ $textAbout }}</p>
                    @php 
                        if ($worker->socials !== null){
                            $arSocials = json_decode($worker->socials, 1);

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