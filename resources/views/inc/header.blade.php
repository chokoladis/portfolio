@php
    $theme = request()->cookie('theme');

    if(!$theme){
        $theme = 'dark';
    }    
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{$theme}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="author" content="chokoladis">
        <meta name="keywords" content="{{ _('Создать портфолио, свое портфолио') }}">
        <meta name="description" content="{{ _('Создай свое портфолио бесплатно за 5 минут!') }}">
        <link rel="shortcut icon" href="/portfolioicon.png" type="image/x-png">
        
        <title>@yield('page.title', config('app.name'))</title>
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.16.22/dist/css/uikit.min.css" />

        <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.22/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.22/dist/js/uikit-icons.min.js"></script>
        
        @vite(['resources/scss/app.scss'])
        @stack('styles')
    </head>
    <body class="antialiased">
        <div class="root">
            
            @if($status = session()->get('status') && $msg = session()->pull('msg'))
                <script>
                    UIkit.notification({
                        message: '{{ $msg }}',
                        status: '{{ session()->get('status') }}',
                        timeout: 5000
                    });
                </script>
            @endif

            <header class="header">
                <div class="container">
                    <div class="theme-toggle"></div>
                    <ul class="header-main">
                        <div class="btn-mob-menu">
                            <span></span>
                        </div>
                        <x-main-menu-li route="{{ route('home') }}">
                            {{ trans('menu.home') }}
                        </x-main-menu-li>

                        <x-main-menu-list-active />
                        
                        <li class="search">
                            <form action="{{ route('search') }}" method="GET">
                                <input type="search" name="search" minlength="3" maxlength="40" size="30"
                                    value="{{ Request::get('search') ? Request::get('search') : '' }}" autocomplete="on"
                                    required>
                                <input type="submit" class="uk-button uk-button-search" value="{{ trans('menu.search') }}">
                            </form>
                        </li>

                        <div class="personal">
                            @guest
                                @if (Route::has('login'))
                                    <x-main-menu-li route="{{ route('login') }}" a_class='nav-link'>
                                        {{ trans('menu.login') }}
                                    </x-main-menu-li>
                                @endif

                                @if (Route::has('register'))
                                    <x-main-menu-li route="{{ route('register') }}" a_class='nav-link'>
                                        {{ trans('menu.registration') }}
                                    </x-main-menu-li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ mb_strlen(auth()->user()->fio) > 13 ? mb_substr(auth()->user()->fio, 0, 13).'...' : auth()->user()->fio  }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('profile.index') }}">{{ trans('menu.profile') }}</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ trans('menu.quit') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </div>
                    </ul>
                </div>
            </header>

            <div class="mob-menu">
                
                <div class="close">X</div>

                <form action="{{ route('search') }}" method="GET">
                    <input type="search" name="search" minlength="3" maxlength="40" size="30"
                        value="{{ Request::get('search') ? Request::get('search') : '' }}" autocomplete="on"
                        required>
                    <input type="submit" class="uk-button uk-button-search" value="Поиск">
                </form>
                
                <ul>
                    <x-main-menu-li route="{{ route('home') }}">
                        {{ trans('menu.home') }}
                    </x-main-menu-li>
    
                    <x-main-menu-list-active />

                    <div class="personal">
                        @guest
                            @if (Route::has('login'))
                                <x-main-menu-li route="{{ route('login') }}" a_class='nav-link'>
                                    {{ trans('menu.login') }}
                                </x-main-menu-li>
                            @endif

                            @if (Route::has('register'))
                                <x-main-menu-li route="{{ route('register') }}" a_class='nav-link'>
                                    {{ trans('menu.registration') }}
                                </x-main-menu-li>
                            @endif
                        @endguest
                    </div>
                </ul>
            </div>
            <!-- <div class="theme-toggle">
                <img src="/storage/general/switch.png" alt="">
            </div> -->