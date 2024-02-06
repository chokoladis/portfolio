@extends('layouts.main')

@section('breadcrumb'){{ Breadcrumbs::render('works') }}@endsection

@php
    $arSearch = [];
    $f_search = request('work') ? true : false;
    $f_profile = request('profile') ? true : false;

    if (request('work')){
        $searchVal = htmlspecialchars(request('work'));
        array_push($arSearch, $searchVal);
    }
    
    if (request('profile')){
        $profileVal = htmlspecialchars(request('profile'));
        array_push($arSearch, $profileVal);
    }

    $strSearch = implode(', ',$arSearch);
    
    $title = $strSearch ? __('Поиск по запросу - '.$strSearch) :  __('Работы');
@endphp

@section('page.title'){{ $title }}@endsection

@push('styles')
    @vite(['resources/scss/works.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/works.js'])
@endpush

@section('content')
    
    <header class="header-filter">
        <div class="container">
            <form action="{{ route('work.index') }}" method="GET" id="work-filter">
                <ul class="one-row {{ $f_profile || $f_search ? 'active' : '' }} ">
                    <li class="search {{ $f_search ? 'active' : '' }}">
                        <div class="btn">
                            <span uk-icon="search"></span>
                        </div>
                        <div class="inputs">
                            <input type="search" name="work" minlength='2' value="{{ htmlspecialchars(request('work')) }}" autocomplete="on" placeholder="Поиск по работам в портфолио">
                        </div>
                    </li>
                    <li class="filter {{ $f_profile ? 'active' : '' }}">
                        <div class="btn">
                            <span uk-icon="settings"></span>
                        </div>
                        <div class="inputs">
                            <input type="text" name="profile" minlength='2' value="{{ htmlspecialchars(request('profile')) }}" autocomplete="on" placeholder="Поиск по пользователю">
                        </div>
                    </li>
                    <input type="submit" value="Поиск" class="uk-button uk-button-default">
                </ul>
            </form>
        </div>
    </header>
    
    <main>
        <div class="container">
            @include('compiled.works')

            @if(auth()->user() !== null)
                <button class="uk-button uk-button-default" uk-toggle="target: #md-work_create" type="button">Добавить</button>
            @endif
        </div>
    </main>

@endsection