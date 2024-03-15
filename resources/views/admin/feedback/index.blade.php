@extends('layouts.admin')

{{-- @push('styles') --}}
    {{-- @vite(['resources/scss/works.scss'])
    @vite(['resources/scss/admin/works.scss']) --}}
{{-- @endpush --}}
{{-- @push('scripts')
    @vite(['resources/js/admin/works.js'])
@endpush --}}

@section('title-content') {{ __('Обратная связь') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.feedback') }}@endsection

@section('content')
    
    <section class="content">
        <div class="container-fluid">

            @include('compiled.admin.feedbacks')

        </div>
    </section>
    
    
@endsection