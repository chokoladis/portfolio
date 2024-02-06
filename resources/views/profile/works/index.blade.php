<?php
    use App\Http\Controllers\HelperController;
?>
@extends('layouts.main')

@section('breadcrumb'){{ Breadcrumbs::render('profile.works') }}@endsection
@section('page.title') {{ __('Мои работы') }} @endsection

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
                <div class="uk-child-width-1-1 uk-grid-small uk-grid-match" uk-grid>
                    @foreach($works as $work)
                        <div>
                            <div class="uk-card uk-card-primary uk-card-body">
                                <a href="{{ route('work.detail',$work->slug) }}">
                                    <h3 class="uk-card-title">{{ $work->title }}</h3>
                                </a>
                                <p>{{ $work->description }}</p>
                                <a href="{{ route('profile.work.edit',$work->slug) }}" class="uk-button uk-button-warning">Редактировать</a>
                                <a href="{{ route('profile.work.delete',$work->slug) }}" class="uk-button uk-button-danger">Удалить</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="paginastion">
                    {{$works->links()}}
                </div>
            </section>
        </div>
    </main>

@endsection