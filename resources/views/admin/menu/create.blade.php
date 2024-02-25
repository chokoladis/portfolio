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
                        {{ __('Меню редактор - создать')}}</h1>
                </div>  
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Menu</li>
                    </ol>
                </div>  
            </div> 
        </div> 
    </div>
     
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