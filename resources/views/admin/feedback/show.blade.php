@extends('layouts.admin')

@section('title-content') {{ __('Заявка от '.$feedback->email) }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.feedback.show', $feedback) }}@endsection

@section('content')
    
    <section class="content">
        <div class="container-fluid">

            {{-- todo rows data html --}}
            @php 
                dump($feedback);                
            @endphp

        </div>
    </section>
    
    
@endsection