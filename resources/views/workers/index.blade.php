@extends('layouts.main')

@push('styles')
    @vite(['resources/scss/workers.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/workers.js'])
@endpush

@section('content')
    
    <!-- <header class="header-filter">
        <div class="container">
            <ul>
                <li class="search">
                    <div class="btn">
                        
                        <span uk-icon="search"></span>
                    </div>
                    <form action="" method="get">
                        <input type="search" name="q" id="" minlength='2' value="" placeholder="Введите поисковой запрос">
                    </form>
                </li>
                <li class="filter">
                    <div class="btn">
                        <span uk-icon="settings"></span>
                    </div>
                    <form action="" method="get">

                    </form>
                </li>
            </ul>
        </div>
    </header> -->
    
    <main>
        <div class="container">
            @include('compiled.workers')

            @if (empty($workerById))
                <button class="uk-button uk-button-default" uk-toggle="target: #md-worker_new" type="button">Создать Workers профиль</button>            
            @endif
        </div>
    </main>

@endsection