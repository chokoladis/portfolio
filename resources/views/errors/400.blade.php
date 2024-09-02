@extends('layouts.main')

@php
    $arImg = [
        '/storage/general/errors/400_1.gif',
        '/storage/general/errors/400_2.gif',
        '/storage/general/errors/400_3.gif'
    ];

    $randomImg = $arImg[rand(0,2)];
@endphp
@section('content')
    <main class="page-error">
        <div class="container">
            <div class="uk-card text-center mt-5">
                <h3 class="uk-text-warning">{{ __('Не пон') }}</h3>
                <p class="uk-text-warning">{{ __('Не корректный запрос') }}</p>
                <h1>400</h1>
                <img src="{{ $randomImg }}" alt="400" style="max-height: 450px; width: 450px;">
            </div>
        </div>
    </main>
@endsection