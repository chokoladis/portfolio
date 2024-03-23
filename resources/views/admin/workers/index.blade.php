@extends('layouts.admin')

@push('styles')
    @vite(['resources/scss/workers.scss'])
    @vite(['resources/scss/admin/workers.scss'])
@endpush

@section('title-content') {{ __('Профили') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.workers') }}@endsection

@section('content')

    <header class="header-filter">
        <div class="container">
            <form action="{{ route('admin.workers.index') }}" method="GET" enctype="multipart/form-data">

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
                {{-- <label>
                    <input type="checkbox" name="show_deleted" class="uk-checkbox" {{ request('show_deleted') ? 'checked' : '' }}>
                    {{ __('Удаленные') }}
                </label> --}}

                <input type="submit" value="Применить" class="uk-button uk-button-default d-none">
            </form>
        </div>
    </header>

     
    <section class="content">
        <div class="container-fluid">
            
            @include('compiled.admin.workers')

        </div> 
    </section>
     
    
@endsection