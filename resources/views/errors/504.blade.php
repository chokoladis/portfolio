@extends('layouts.main')

@php
    $arImg = [
        '/storage/general/errors/504_1.gif',
        '/storage/general/errors/504_2.png',
    ];

    $randomImg = $arImg[rand(0,1)];
@endphp

@section('content')
    <main>
        <div class="container">
            <div class="uk-card text-center mt-5">
                <h3 class="uk-text-warning">{{ __('Это фиаско...сервер устал') }}</h3>
                <p class="uk-text-warning">{{ __('Сервер не смог обработать запрос за определенное время') }}</p>
                <h1>504</h1>
                <img src="{{ $randomImg }}" alt="504">
            </div>
        </div>
    </main>
@endsection