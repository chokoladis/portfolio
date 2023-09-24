@extends('layouts.main')

@push('styles')
    @vite(['resources/scss/works.scss'])
@endpush

@php
    $f_search = false;
    $search_val = '';

    if (isset($_GET['q'])){
        $f_search = true;
        $search_val = $_GET['q'];
    }

    $f_profile = false;
    $profile_val = '';

    if (isset($_GET['profile'])){
        $f_profile = true;
        $profile_val = $_GET['profile'];
    }
    
@endphp
@section('content')
    
    <header class="header-filter">
        <div class="container">
            <form action="" method="get">
                <ul class="one-row {{ $f_profile || $f_search ? 'active' : '' }} ">
                    <li class="search {{ $f_search ? 'active' : '' }}">
                        <div class="btn">
                            <span uk-icon="search"></span>
                        </div>
                        <div class="inputs">
                            <input type="search" name="q" minlength='2' value="{{ $search_val }}" placeholder="Поиск по работам в портфолио">
                        </div>
                    </li>
                    <li class="filter {{ $f_profile ? 'active' : '' }}">
                        <div class="btn">
                            <span uk-icon="settings"></span>
                        </div>
                        <div class="inputs">
                            <input type="text" name="profile" minlength='2' value="{{ $profile_val }}" placeholder="Поиск по пользователю">
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

            <button class="uk-button uk-button-default" uk-toggle="target: #md-work_create" type="button">Добавить</button>
        </div>
    </main>

@endsection