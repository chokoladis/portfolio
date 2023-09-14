@extends('layouts.main')

@push('styles')
    @vite(['resources/scss/works.scss'])
@endpush

@section('content')
    
    <header class="header-filter">
        <div class="container">
            <ul>
                <li>
                    <div class="btn">
                        <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                        <span uk-icon="search"></span>
                    </div>
                    <form action="" method="get">
                        <input type="search" name="" id="" value="{{ $_GET['q'] }}">
                    </form>
                </li>
                <li>
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
            @include('compiled.works')

            <button class="uk-button uk-button-default" uk-toggle="target: #md-work_create" type="button">Добавить</button>
        </div>
    </main>

@endsection