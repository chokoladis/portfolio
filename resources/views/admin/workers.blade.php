@extends('layouts.admin')

@push('styles')
    @vite(['resources/scss/workers.scss'])
    @vite(['resources/scss/admin/workers.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/admin/workers.js'])
@endpush

@php
    $f_search = false;

    $f_profile = false;
    $profile_val = '';

    if (isset($_GET['profile'])){
        $f_profile = true;
        $profile_val = htmlspecialchars($_GET['profile']);
    }
    
@endphp

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Workers</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
                    <li class="breadcrumb-item active">Workers</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <header class="header-filter">
        <div class="container">
            <form action="{{ route('admin.workers') }}" method="GET" id="worker-filter">
                <ul class="one-row {{ $f_profile ? 'active' : '' }} ">
                    <li class="filter {{ $f_profile ? 'active' : '' }}">
                        <div class="btn">
                            <span uk-icon="settings"></span>
                        </div>
                        <div class="inputs">
                            <input type="text" name="profile" minlength='2' value="{{ $profile_val }}" autocomplete="on" placeholder="Введите имя или телефон пользователя">
                        </div>
                    </li>
                    <input type="submit" value="Поиск" class="uk-button uk-button-default">
                </ul>
            </form>
        </div>
    </header>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @include('compiled.workers')
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    
@endsection