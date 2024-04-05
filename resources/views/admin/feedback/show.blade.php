@extends('layouts.admin')

@section('title-content') {{ __('Заявка от '.$feedback->email) }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.feedback.show', $feedback) }}@endsection

@section('content')
    
    <section class="content">
        <div class="container-fluid">

            <x-model-additional :model="$feedback" crud="Feedback" new_line="true"></x-model-additional>

        </div>
    </section>
    
    
@endsection