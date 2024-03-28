@extends('layouts.admin')

@push('styles')
    @vite(['resources/scss/works.scss'])
    @vite(['resources/scss/admin/works.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/admin/works.js'])
@endpush

@section('title-content') {{ __('Корзина') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.works.recycle') }}@endsection

@section('content')

    <header class="header-filter">
        <div class="container">
            <form action="{{ route('admin.works.recycle') }}" method="GET" id="work-filter">
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

                <input type="submit" value="Поиск" class="uk-button uk-button-default d-none">
            </form>
        </div>
    </header>

    <section class="content">
        <div class="container-fluid">

            <div class="works-actions">
                <b>{{ __('Применить к выделенным:') }}</b>
                <div class="action js-delete">{{ __('Удалить') }}</div>
                <div class="action js-restore">{{ __('Восстановить') }}</div>
            </div>

            @include('compiled.admin.works-recycle')

        </div> 
    </section>
     
    
@endsection