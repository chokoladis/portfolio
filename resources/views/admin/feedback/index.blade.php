@extends('layouts.admin')

@section('title-content') {{ __('Обратная связь') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.feedback') }}@endsection

@section('content')
    
    <section class="content">
        <div class="container-fluid">

            @include('compiled.admin.feedbacks')

        </div>
    </section>
    
    
@endsection