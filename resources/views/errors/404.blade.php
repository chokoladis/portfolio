@extends('layouts.main')

@section('content')
    <main>
        <div class="container">
            <div class="uk-card text-center mt-5">
                <h3 class="uk-text-warning">{{ __('Ты ошибься номер друг') }}</h3>
                <p class="uk-text-warning">{{ __('Проверьте правильность ссылки') }}</p>
                <h1>404</h1>
                <img src="{{ '/storage/general/errors/404.gif' }}" alt="">
            </div>
        </div>
    </main>
@endsection