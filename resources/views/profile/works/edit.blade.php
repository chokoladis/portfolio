<?php
    use App\Http\Controllers\HelperController;
?>
@extends('layouts.main')

@section('breadcrumb'){{ Breadcrumbs::render('profile.works.edit', $work) }}@endsection
@section('page.title') {{ __('Мои работы - '.$work->title) }} @endsection

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
                <form action="{{ route('profile.works.update') }}" method="POST">
                    @csrf
                    
                    @include('compiled.admin.form')
                
                    <input type="submit" value="{{ __('Добавить') }}" class="uk-button uk-button-primary">
                </form>     
            </section>
        </div>
    </main>

@endsection