@extends('layouts.admin')

@section('title-content') {{ __('Категории') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.category') }}@endsection

@section('content')

    <section class="content">
        <div class="container-fluid">

{{--            @include('compiled.admin.feedbacks')--}}

        </div>
    </section>


@endsection
