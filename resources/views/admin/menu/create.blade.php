@php
    use App\Models\MenuNav;
@endphp

@extends('layouts.admin')

@push('styles')
    @vite(['resources/scss/admin/menu.scss'])
@endpush

@section('title-content') {{ __('Создание пункта меню')}} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.menu.add') }}@endsection

@section('content')
     
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.menu.store') }}" method="POST">
                @csrf
                
                <div class="uk-margin">
                    <input class="uk-input" type="text" name="name"
                        placeholder="{{ __('Название') }}" required>
                </div>
                <div class="uk-margin">
                    <input class="uk-input" type="text" name="link" 
                        placeholder="{{ __('Ссылка') }}" required>
                </div>
                <div class="uk-margin">
                    <select class="uk-select" aria-label="Select" name="role">
                        @foreach (MenuNav::LIST_ROLE as $code)
                            <option>{{ $code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="uk-margin">
                    <label><input class="uk-radio" type="radio" name="active" value="1" checked>{{ __('Активная') }}</label>
                    <label><input class="uk-radio" type="radio" name="active" value="0">{{ __('Не активная') }}</label>
                </div>
                <div class="uk-margin">
                    <input class="uk-input" type="number" name="sort"
                        placeholder="{{ __('Сортировка') }}">
                </div>

                <input type="submit" value="{{ __('Добавить') }}" class="uk-button uk-button-primary">
            </form>
        </div>
    </section>

@endsection