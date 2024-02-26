@extends('layouts.admin')

@section('title-content') {{ __('Панель') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin') }}@endsection

@section('content')
     
    <section class="content">
        <div class="container-fluid">
            <!-- <h2>{{ __('Панель') }}</h2> -->
        </div>
    </section>
     

@endsection