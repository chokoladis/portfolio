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
                        {{ __('Меню редактор')}}</h1>
                </div>  
                <div class="col-sm-6">
                    {{-- todo breadcrumbs --}}
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
            @include('compiled.menu_list')
            
            <a href="{{ route('admin.menu.create') }}" class="uk-button uk-button-primary">Добавить</a>
        </div> 
    </section>
     

@endsection