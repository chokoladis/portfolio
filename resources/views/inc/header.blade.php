@php
    $theme = \App\Http\Controllers\HelperController::getTheme();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{$theme}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="author" content="chokoladis">

        <meta name="yandex-verification" content="f1b55fd121a25479" />
        <meta name="google-site-verification" content="MKcmf-D2QV_nclfq_5lUAtAGOh8rM8LCKdZFOzKGKz0" />

        <link rel="shortcut icon" href="/portfolioicon.png" type="image/x-png">

        {{-- todo seo controller --}}
        <title>@yield('page.title', config('app.name'))</title>
        <meta name="keywords" content="{{ _('Создать портфолио, создать портфолио онлайн бесплатно, создать портфолио онлайн, портфолио для работы, service creation free portfolio, make portfolio online free') }}">
        <meta name="description" content="{{ _('Создай портфолио работ бесплатно!') }}">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.16.22/dist/css/uikit.min.css" />

        <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.22/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.22/dist/js/uikit-icons.min.js"></script>
        {{-- <script src="{{ asset('') }}"></script> --}}

        @vite(['resources/scss/app.scss'])
        @stack('styles')

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(98259871, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true
            });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/98259871" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
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
                        <x-menu.main-li route="{{ route('home') }}">
                            {{ __('menu.home') }}
                        </x-menu.main-li>

                        <x-menu.main />

                        <li class="search">
                            <form action="{{ route('search') }}" method="GET">
                                <input type="search" name="search" minlength="3" maxlength="40" size="30"
                                    value="{{ Request::get('search') ? Request::get('search') : '' }}" autocomplete="on"
                                    required>
                                <input type="submit" class="uk-button uk-button-search" value="{{ __('menu.search') }}">
                            </form>
                        </li>

                        <div class="personal">
                            @guest
                                @if (Route::has('login'))
                                    <x-menu.main-li route="{{ route('login') }}" a_class='nav-link'>
                                        {{ __('menu.login') }}
                                    </x-menu.main-li>
                                @endif

                                @if (Route::has('register'))
                                    <x-menu.main-li route="{{ route('register') }}" a_class='nav-link'>
                                        {{ __('menu.registration') }}
                                    </x-menu.main-li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ mb_strlen(auth()->user()->fio) > 13 ? mb_substr(auth()->user()->fio, 0, 13).'...' : auth()->user()->fio  }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('profile.index') }}">{{ __('menu.profile') }}</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('menu.quit') }}
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
                    <x-menu.main-li route="{{ route('home') }}">
                        {{ __('menu.home') }}
                    </x-menu.main-li>

                    <x-menu.main />

                    <div class="personal">
                        @guest
                            @if (Route::has('login'))
                                <x-menu.main-li route="{{ route('login') }}" a_class='nav-link'>
                                    {{ __('menu.login') }}
                                </x-menu.main-li>
                            @endif

                            @if (Route::has('register'))
                                <x-menu.main-li route="{{ route('register') }}" a_class='nav-link'>
                                    {{ __('menu.registration') }}
                                </x-menu.main-li>
                            @endif
                        @endguest
                    </div>
                </ul>
            </div>
            <!-- <div class="theme-toggle">
                <img src="/storage/general/switch.png" alt="">
            </div> -->
