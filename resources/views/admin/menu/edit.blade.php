@php
    use App\Models\MenuNav;
@endphp

@extends('layouts.admin')

@push('styles')
    @vite(['resources/scss/admin/menu.scss'])
@endpush

@section('content')

     
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-link"></i>
                        {{ __('Редактирование пункта меню')}}
                    </h1>
                </div>  
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Menu') }}</li>
                    </ol>
                </div>  
            </div> 
        </div> 
    </div>
     

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.menu.update', $menuNav) }}" method="POST" id="menu_edit" accept-charset="multipart/form-data">
                
                @csrf
        
                <div class="uk-margin">
                    <input class="uk-input" type="text" name="name"
                        placeholder="{{ __('Название') }}" value="{{ $menuNav->name }}">
                </div>
                <div class="uk-margin">
                    <input class="uk-input" type="text" name="link" 
                        placeholder="{{ __('Ссылка') }}" value="{{ $menuNav->link }}">
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
                        placeholder="{{ __('Сортировка') }}" value="{{ $menuNav->sort }}">
                </div>
            
                <input class="uk-button uk-button-default" type="submit" id="js_menu_edit_submit" value="{{ __('Обновить') }}">
            </form>
        </div>
    </section>

@endsection