<?php
    use App\Http\Controllers\HelperController;
?>
@extends('layouts.main')

@push('styles')
    @vite(['resources/scss/profile.scss'])
    @vite(['resources/scss/workers.scss'])
@endpush

@section('content')    
    <main>
        <div class="container">
            <section class="worker-works">
                @if (!empty($works))
                    @foreach($works as $work)
                        title - {{ $work->title }}
                    @endforeach
                @else
                    <p>У пользователя нет пример работ</p>
                @endif
            </section>
        </div>
    </main>

@endsection