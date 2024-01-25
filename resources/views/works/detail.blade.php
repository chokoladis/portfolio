@extends('layouts.main')

@section('page.title'){{ __('Работы - '.$work->title) }}@endsection
@push('styles')
    @vite(['resources/scss/works.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/works.js'])
@endpush

@php   
    $arFilesPath = explode(',', $work->url_files);

    if($worker = $work->user->workers){
        $linkToWorker = route('workers.detail', $worker->code);
    } else {
        $linkToWorker = '#';
    }
@endphp
@section('content')
    
    <main>
        <div class="container">
            
            <div class="work-detail uk-card uk-card-default" data-id="{{ $work->slug }}">
                <div class="uk-card-media-top">
                    <img src="/storage/works/img/{{ trim($arFilesPath[0]) }}">
                </div>
                <div class="uk-card-body">
                    
                    <a href="{{ $linkToWorker }}" class="uk-card-badge uk-label">{{ $work->user->name }}</a>
                    <h3 class="uk-card-title">{{ $work->title }}</h3>
                    <a href="{{ $work->url_work }}">{{ $work->url_work }}</a>
                    <p>{{ $work->description }}</p>
                </div>
                <div class="uk-card-footer">
                    <div class="dates">
                        <p>Создано - <span>{{ $work->created_at }}</span></p>
                        @if($work->updated_at != $work->created_at)
                            <p>Обновлено - <span>{{ $work->updated_at }}</span></p>
                        @endif
                    </div>
                    @can('edit', $work)
                        <a href="#" class="uk-button uk-button-text js_work_edit">{{ __('Редактировать') }}</a>    
                    @endcan
                </div>
            </div>

            <div class="uk-child-width-1-1 uk-child-width-1-2@m uk-child-width-1-3@l uk-margin-medium-top" uk-grid uk-lightbox="animation: slide">
                @foreach ($arFilesPath as $path)
                    <div>
                        <a class="uk-inline" href="/storage/works/img/{{ trim($path) }}">
                            <img src="/storage/works/img/{{ trim($path) }}" width="1800" height="1200">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

@endsection