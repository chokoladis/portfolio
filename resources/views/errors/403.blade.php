@extends('layouts.main')

@php
    $arImg = [
        '/storage/general/errors/403_1.gif',
        '/storage/general/errors/403_2.png',
    ];

    $randomImg = $arImg[rand(0,1)];
@endphp

@section('content')
    <main>
        <div class="container">
            <div class="uk-card text-center mt-5">
                <h3 class="uk-text-warning">{{ __('Не твой уровень, дорогой') }}</h3>
                <p class="uk-text-warning">{{ __('Доступ запрещен') }}</p>
                <h1>403</h1>
                <img src="{{ $randomImg }}" alt="">
            </div>
        </div>
    </main>
@endsection