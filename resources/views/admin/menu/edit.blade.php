@php
    use App\Models\MenuNav;
@endphp

@extends('layouts.admin')

@push('styles')
    @vite(['resources/scss/admin/menu.scss'])
@endpush

@section('title-content') {{ __('Редактирование')}} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.menu.edit', $menuNav) }}@endsection

@section('content')     

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.menu.update', $menuNav) }}" method="POST" id="menu_edit" accept-charset="multipart/form-data">
                
                @csrf
        
                <div class="uk-margin">
                    <input class="uk-input" type="text" name="name"
                        placeholder="{{ __('Название') }}" value="{{ trans('menu.'.$menuNav->name) }}">
                </div>
                <div class="uk-margin">
                    <input class="uk-input" type="text" name="link" 
                        placeholder="{{ __('Ссылка') }}" value="{{ $menuNav->link }}">
                </div>
                <div class="uk-margin">
                    
                    <select class="uk-select" aria-label="Select" name="role">
                        @php
                            foreach (MenuNav::LIST_ROLE as $code){
                                $select = $menuNav->role === $code ? 'selected' : '';
                                echo '<option '.$select.'>'. $code .'</option>';
                            }
                        @endphp
                    </select>
                </div>
                <div class="uk-margin">
                    @php 
                        $active = $menuNav->active;
                    @endphp
                    <label><input class="uk-radio" type="radio" name="active" value="1" {{ $active ? 'checked' : '' }}>{{ __('Активная') }}</label>
                    <label><input class="uk-radio" type="radio" name="active" value="0" {{ $active ? '' : 'checked' }}>{{ __('Не активная') }}</label>
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