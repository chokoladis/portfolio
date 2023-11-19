@extends('layouts.main')

@push('styles')
    @vite(['resources/scss/profile.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/profile.js'])
@endpush

@section('content')
    
    <!-- <header class="header-filter">
        <div class="container">
            <ul>
                <li class="search">
                    <div class="btn">
                        
                        <span uk-icon="search"></span>
                    </div>
                    <form action="" method="get">
                        <input type="search" name="q" id="" minlength='2' value="" placeholder="Введите поисковой запрос">
                    </form>
                </li>
                <li class="filter">
                    <div class="btn">
                        <span uk-icon="settings"></span>
                    </div>
                    <form action="" method="get">

                    </form>
                </li>
            </ul>
        </div>
    </header> -->
    
    <main>
        <div class="container">
            <section class="worker">
                @php
                    $imgUrl = $worker->url_avatar && file_exists(public_path($worker->url_avatar)) ? $worker->url_avatar : '/storage/general/user.png' ;

                    if ($worker->about){
                        $f_about = true;
                        $textAbout = $worker->about;
                    } else {
                        $f_about = false;
                        $textAbout = 'Вы не заполнили информацию о себе';
                    }
                @endphp
                <div class="small_info">
                    <form class="form_change_img" action='{{ route("profile.change_avatar") }}' method="POST">
                        <img src="{{ $imgUrl }}" alt="user avatar">
                        <div class="file_change">Изменить</div>
                        <input type="file" name="new_user_avatar" accept="image/*">
                        <input type="submit" value="Изменить">
                    </form>
                    <h3 class="name">{{ $worker->name }}</h3>
                    <a href="tel:{{ $worker->phone }}">{{ $worker->phone }}</a>
                    <!-- какая то ещё небольшая инфа -->
                </div>
                <div class="big_info">
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