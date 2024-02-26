@extends('layouts.admin')

{{-- @push('styles') --}}
    {{-- @vite(['resources/scss/works.scss'])
    @vite(['resources/scss/admin/works.scss']) --}}
{{-- @endpush --}}
{{-- @push('scripts')
    @vite(['resources/js/admin/works.js'])
@endpush --}}

@section('content')

    
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Feedback') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/">{{ __('Панель') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Feedback') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    
    <section class="content">
        <div class="container-fluid">

            @include('compiled.admin.feedbacks')

        </div>
    </section>
    
    
@endsection