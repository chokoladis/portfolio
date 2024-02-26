@extends('layouts.admin')

@push('styles')
    @vite(['resources/scss/admin/menu.scss'])
@endpush

@section('title-content') {{ __('Меню') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.menu') }}@endsection

@section('content')
     
    <section class="content">
        <div class="container-fluid">
            @include('compiled.menu_list')
            
            <a href="{{ route('admin.menu.create') }}" class="uk-button uk-button-primary">Добавить</a>
        </div> 
    </section>
     

@endsection