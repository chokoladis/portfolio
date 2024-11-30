@extends('layouts.admin')

@section('title-content') {{ __('Категории') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.category') }}@endsection

@section('content')

    <section class="content">
        <div class="container-fluid">

{{--            todo filters --}}
            {!! $table !!}

        </div>
    </section>


@endsection
