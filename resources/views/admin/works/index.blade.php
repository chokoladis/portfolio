@extends('layouts.admin')

@push('styles')
    @vite(['resources/scss/works.scss'])
    @vite(['resources/scss/admin/works.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/admin/works.js'])
@endpush

@php
    $f_search = request('work') ? true : false;
    $f_profile = request('profile') ? true : false;

    $f_search = false;
    $search_val = '';

    if (request('work')){
        $f_search = true;
        $search_val = htmlspecialchars(request('work'));
    }

    $f_profile = false;
    $profile_val = '';

    if (request('profile')){
        $f_profile = true;
        $profile_val = htmlspecialchars(request('profile'));
    }    
@endphp

@section('title-content') {{ __('Примеры работ') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.works') }}@endsection

@section('content')

    <header class="header-filter">
        <div class="container">
            <form action="{{ route('admin.works.index') }}" method="GET" id="work-filter">
                <input type="search" name="work" minlength='2'
                        value="{{ htmlspecialchars(request('work')) }}" 
                        autocomplete="on" placeholder="Поиск по работе">
                    
                <input type="text" name="profile" minlength='2'
                    value="{{ htmlspecialchars(request('profile')) }}" 
                    autocomplete="on" placeholder="Пользователь">
                
                <label for="created_at_from">
                    {{ __('Создание с') }}
                    <input type="datetime-local" name="created_at_from"
                        value="{{ htmlspecialchars(request('created_at_from')) }}" 
                        autocomplete="on">
                </label>

                <label for="created_at_to">
                    по
                    <input type="datetime-local" name="created_at_to"
                        value="{{ htmlspecialchars(request('created_at_to')) }}" 
                        autocomplete="on">
                </label>
                <label>
                    <input type="checkbox" name="show_deleted" class="uk-checkbox" {{ request('show_deleted') ? 'checked' : '' }}>
                    {{ __('Удаленные') }}
                </label>

                <input type="submit" value="Поиск" class="uk-button uk-button-default d-none">
            </form>
        </div>
    </header>

     
    <section class="content">
        <div class="container-fluid">
            
            @include('compiled.admin.works')

        </div> 
    </section>
     
    
@endsection