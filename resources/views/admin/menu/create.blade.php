@extends('layouts.admin')

@push('styles')
    @vite(['resources/scss/admin/menu.scss'])
@endpush

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-link"></i>
                        {{ __('Меню редактор - создать')}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Menu</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.menu.store') }}" method="POST">
                @csrf
                
                @include('compiled.admin.form')

                <input type="submit" value="{{ __('Добавить') }}" class="uk-button uk-button-primary">
            </form>
        </div><!--/. container-fluid -->
    </section>

@endsection