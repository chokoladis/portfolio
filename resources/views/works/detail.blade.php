@extends('layouts.main')

@push('styles')
    @vite(['resources/scss/works.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/works.js'])
@endpush

@php
    $f_search = false;
    // $search_val = '';

    if (isset($_GET['q'])){
        $f_search = true;
        // $search_val = htmlspecialchars($_GET['q']);
    }

    $f_profile = false;
    // $profile_val = '';

    if (isset($_GET['profile'])){
        $f_profile = true;
        // $profile_val = htmlspecialchars($_GET['profile']);
    }
    
    $arFilesPath = explode(',', $work->url_files);
@endphp
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
                            <input type="search" name="q" minlength='2' value="{{ old('q') }}" autocomplete="on" placeholder="Поиск по работам в портфолио">
                        </div>
                    </li>
                    <li class="filter {{ $f_profile ? 'active' : '' }}">
                        <div class="btn">
                            <span uk-icon="settings"></span>
                        </div>
                        <div class="inputs">
                            <input type="text" name="profile" minlength='2' value="{{ old('profile') }}" autocomplete="on" placeholder="Поиск по пользователю">
                        </div>
                    </li>
                    <input type="submit" value="Поиск" class="uk-button uk-button-default">
                </ul>
            </form>
        </div>
    </header>
    
    <main>
        <div class="container">
            <div class="work-detail uk-card uk-card-default" data-id="{{ $work->slug }}">
                <div class="uk-card-media-top">
                    <img src="/storage/works/img/{{ trim($arFilesPath[0]) }}" width="" height="" alt="">
                </div>
                <div class="uk-card-body">
                    <div class="uk-card-badge uk-label">{{ $work->user->name }}</div>
                    <h3 class="uk-card-title">{{ $work->title }}</h3>
                    <a href="{{ $work->url_work }}">{{ $work->url_work }}</a>
                    <p>{{ $work->description }}</p>
                </div>
                <div class="uk-card-footer">
                    <div class="dates">
                        <p>Создано - <span>{{ $work->created_at }}</span></p>
                        @if($work->updated_at !== $work->created_at)
                            <p>Обновлено - <span>{{ $work->updated_at }}</span></p>
                        @endif
                    </div>
                    <a href="#" class="uk-button uk-button-text js_work_edit">{{ __('Редактировать') }}</a>
                </div>
            </div>
        </div>
    </main>

@endsection