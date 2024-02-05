<?php
    use App\Http\Controllers\HelperController;
?>
@extends('layouts.main')

@section('page.title') {{ __('Профиль - работы') }} @endsection

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