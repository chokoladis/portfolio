@extends('layouts.admin')

@push('styles')
    @vite(['resources/scss/works.scss'])
    @vite(['resources/scss/admin/works.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/admin/works.js'])
@endpush

@php
    $f_search = false;
    $search_val = '';

    if (isset($_GET['q'])){
        $f_search = true;
        $search_val = htmlspecialchars($_GET['q']);
    }

    $f_profile = false;
    $profile_val = '';

    if (isset($_GET['profile'])){
        $f_profile = true;
        $profile_val = htmlspecialchars($_GET['profile']);
    }
    
@endphp

@section('content')

     
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Examples work</h1>
                </div>  
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Examples work</li>
                    </ol>
                </div>  
            </div> 
        </div> 
    </div>
     
    
    <header class="header-filter">
        <div class="container">
            <form action="{{ route('admin.works.index') }}" method="GET" id="work-filter">
                <ul class="one-row {{ $f_profile || $f_search ? 'active' : '' }} ">
                    <li class="search {{ $f_search ? 'active' : '' }}">
                        <div class="btn">
                            <span uk-icon="search"></span>
                        </div>
                        <div class="inputs">
                            <input type="search" name="q" minlength='2' value="{{ $search_val }}" autocomplete="on" placeholder="Поиск по работам в портфолио">
                        </div>
                    </li>
                    <li class="filter {{ $f_profile ? 'active' : '' }}">
                        <div class="btn">
                            <span uk-icon="settings"></span>
                        </div>
                        <div class="inputs">
                            <input type="text" name="profile" minlength='2' value="{{ $profile_val }}" autocomplete="on" placeholder="Поиск по пользователю">
                        </div>
                    </li>
                    <input type="submit" value="Поиск" class="uk-button uk-button-default">
                </ul>
            </form>
        </div>
    </header>

     
    <section class="content">
        <div class="container-fluid">
            
            @include('compiled.admin.works')

            <button class="uk-button uk-button-primary" uk-toggle="target: #md-work_create" type="button">Добавить</button>
        </div> 
    </section>
     
    
@endsection