<?php
    use App\Http\Controllers\HelperController;
?>
@extends('layouts.main')

@section('breadcrumb'){{ Breadcrumbs::render('profile') }}@endsection
@section('page.title') {{ __('Профиль') }} @endsection

@push('styles')
    @vite(['resources/scss/profile.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/profile.js'])
@endpush

@section('content')    
    <main>
        <div class="container">
            <section class="worker">
                @if($isEmptyProfile)
                    @include('profile.unsetWorker')
                @else
                    @include('profile.issetWorker')
                @endif
            </section>
        </div>
    </main>

    @if($isEmptyProfile)
        @include('inc.modal.worker_add')
    @else
        @include('inc.modal.worker_edit')
    @endif
@endsection