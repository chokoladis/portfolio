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
                        Menu editor</h1>
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
            @include('compiled.menu_list')
            
            <button class="uk-button uk-button-primary" uk-toggle="target: #md-menu_add" type="button">Добавить</button>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->

@endsection