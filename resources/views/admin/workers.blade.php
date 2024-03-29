@extends('layouts.admin')

@push('styles')
    @vite(['resources/scss/workers.scss'])
    @vite(['resources/scss/admin/workers.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/admin/workers.js'])
@endpush

@php
    $f_search = false;

    $f_profile = false;
    $profile_val = '';

    if (isset($_GET['profile'])){
        $f_profile = true;
        $profile_val = htmlspecialchars($_GET['profile']);
    }
    
@endphp

@section('title-content') {{ __('Workers') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin-workers') }}@endsection

@section('content')     

    <header class="header-filter">
        <div class="container">
            <form action="{{ route('admin.workers') }}" method="GET" id="worker-filter">
                <ul class="one-row {{ $f_profile ? 'active' : '' }} ">
                    <li class="filter {{ $f_profile ? 'active' : '' }}">
                        <div class="btn">
                            <span uk-icon="settings"></span>
                        </div>
                        <div class="inputs">
                            <input type="text" name="profile" minlength='2' value="{{ $profile_val }}" autocomplete="on" placeholder="Введите имя или телефон пользователя">
                        </div>
                    </li>
                    <input type="submit" value="Поиск" class="uk-button uk-button-default">
                </ul>
            </form>
        </div>
    </header>

     
    <section class="content">
        <div class="container-fluid">
            @include('compiled.workers')
        </div> 
    </section>
     
    
@endsection