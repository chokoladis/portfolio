@extends('layouts.main')


@php
    $arSearch = [];
    $f_profile = request('profile') ? true : false;
    
    if (request('profile')){
        $profileVal = htmlspecialchars(request('profile'));
        array_push($arSearch, $profileVal);
    }

    $strSearch = implode(', ',$arSearch);
    
    $title = $strSearch ? __('Поиск по запросу - '.$strSearch) :  __('Пользователи');
@endphp

@section('page.title'){{ $title }}@endsection

@push('styles')
    @vite(['resources/scss/workers.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/workers.js'])
@endpush

@section('content')
    
    <header class="header-filter">
        <div class="container">
            <form action="{{ route('workers.index') }}" method="GET" id="worker-filter">
                <ul class="one-row {{ $f_profile ? 'active' : '' }} ">
                    <li class="filter {{ $f_profile ? 'active' : '' }}">
                        <div class="btn">
                            <span uk-icon="settings"></span>
                        </div>
                        <div class="inputs">
                            <input type="text" name="profile" minlength='2' value="{{ htmlspecialchars(request('profile')) }}" autocomplete="on" placeholder="Введите имя или телефон пользователя">
                        </div>
                    </li>
                    <input type="submit" value="Поиск" class="uk-button uk-button-default">
                </ul>
            </form>
        </div>
    </header>
    
    <main>
        <div class="container">
            @include('compiled.workers')

            @if (empty($workerById))
                <button class="uk-button uk-button-default js-create-worker" uk-toggle="target: #md-worker_new" type="button">Создать Workers профиль</button>
            @endif
        </div>
    </main>

    @include('inc.modal.worker_new')
@endsection