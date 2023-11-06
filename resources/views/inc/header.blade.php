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
        
        <title>Portfolio on laravel</title>
        <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.16.22/dist/css/uikit.min.css" />

        <!-- UIkit JS -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.22/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.22/dist/js/uikit-icons.min.js"></script>
        @vite(['resources/scss/app.scss'])
        @stack('styles')
    </head>
    <body class="antialiased">
        <div class="root">
                
            <header class="header">
                <div class="container">
                    <!-- <div class="profile">
                        <div class="present">
                            <b>username</b>
                            <hr>
                        </div>
                        <ul class="short_action hide">
                            <li class='animated'><a href="">profile</a></li>
                            <li class='animated'><a href="">settings</a></li>
                            <li class='animated'><a href="">logout</a></li>
                        </ul>
                    </div> -->
                    <!-- <div class="search">
                        <form action="" method="POST" >
                            <input type="text" name='search' id='search'>
                            <button type='submit'>
                                <img src="icon.png" alt="">
                            </button>
                        </form>
                        <img src="icon.png" alt="" class='search-placeholder'>
                    </div> -->
                    <div class="theme-toggle"></div>
                    <ul class="header-main">
                        <li class='animated'><a href="/">home</a></li>
                        
                        @include('compiled.menu_list_active')
                        
                        @guest
                            @if (Route::has('login'))
                                <li class='animated'>
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class='animated'>
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
                
            </header>
            <!-- <div class="theme-toggle">
                <img src="/storage/general/switch.png" alt="">
            </div> -->