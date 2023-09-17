@extends('layouts.main')

@push('styles')
    @vite(['resources/scss/workers.scss'])
@endpush

@section('content')
    
    <header class="header-filter">
        <div class="container">
            <ul>
                <li class="search">
                    <div class="btn">
                        <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                        <span uk-icon="search"></span>
                    </div>
                    <form action="" method="get">
                        <input type="search" name="q" id="" minlength='2' value="{{ $search_val }}" placeholder="Введите поисковой запрос">
                    </form>
                </li>
                <li class="filter">
                    <div class="btn">
                        <!-- <i class="fa-solid fa-filter"></i> -->
                        <span uk-icon="settings"></span>
                    </div>
                    <form action="" method="get">

                    </form>
                </li>
            </ul>
        </div>
    </header>
    
    <main>
        <div class="container">
            @include('compiled.workers')

            <!-- сделать полицию - не отображать для гостей и тех у кого есть профиль воркерс  -->
            <button class="uk-button uk-button-default" uk-toggle="target: #md-work_create" type="button">Создать Workers профиль</button>
            <!-- если есть - кнопка перейти будет в шапке -->
        </div>
    </main>

@endsection