@extends('layouts.main')

@php
    $arImg = [
        '/storage/general/errors/500_1.gif',
        '/storage/general/errors/500_2.png',
    ];

    $randomImg = $arImg[rand(0,1)];
@endphp

@section('content')
    <main>
        <div class="container">
            <div class="uk-card text-center mt-5">
                <h3 class="uk-text-warning">{{ __('Не правильно #bанные волки, широкую на широкую') }}</h3>
                <p class="uk-text-warning">{{ __('На сервере что то отработало не правильно') }}</p>
                <h1>500</h1>
                <img src="{{ $randomImg }}" alt="500">
            </div>
        </div>
    </main>
@endsection