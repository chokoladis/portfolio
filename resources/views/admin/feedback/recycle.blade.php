@extends('layouts.admin')

@section('title-content') {{ __('Корзина') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.feedback.recycle') }}@endsection

@section('content')
    
    <section class="content">
        <div class="container-fluid">

            @include('compiled.admin.feedbacks')

        </div>
    </section>
    
    
@endsection