<?php
    use App\Http\Controllers\HelperController;
?>
@extends('layouts.main')

@section('page.title') {{ __('Работы пользователя - '.$worker->user->name ) }} @endsection

@push('styles')
    @vite(['resources/scss/profile.scss'])
    @vite(['resources/scss/workers.scss'])
@endpush

@section('content')    
    <main>
        <div class="container">
            @if(!$works->count())
                <div class="result_query">
                    {{ __('У пользователя нет пример работ') }}
                </div>
            @else
                <section class="worker-works">
                    @foreach($works as $work)
                        title - {{ $work->title }}
                    @endforeach
                </section>
            @endif
        </div>
    </main>

@endsection