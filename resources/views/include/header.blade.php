<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Portfolio on laravel</title>
        @vite(['resources/scss/app.scss','resources/js/app.js'])
    </head>
    <body class="antialiased">
        <header class="header">
            <div class="container">
                <!-- <div class="profile">
                    <div class="present">
                        <b>username</b>
                        <hr>
                    </div>
                    <ul class="short_action hide">
                        <li><a href="">profile</a></li>
                        <li><a href="">settings</a></li>
                        <li><a href="">logout</a></li>
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
                <ul class="header-main">
                    <li><a href="{{ route('work.index') }}">portfolio</a></li>
                    <li><a href=""></a></li>
                    <li><a href=""></a></li>
                    <li><a href=""></a></li>
                </ul>
            </div>
        </header>
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>