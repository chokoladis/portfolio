@extends('layouts.main')

@section('breadcrumb'){{ Breadcrumbs::render('work', $work) }}@endsection
@section('page.title'){{ __('Работы - '.$work->title) }}@endsection
@push('styles')
    @vite(['resources/scss/works.scss'])
@endpush
@push('scripts')
    @vite(['resources/js/works.js'])
@endpush

@php   
    if($worker = $work->user->workers){
        $linkToWorker = route('workers.detail', $worker->code);
    } else {
        $linkToWorker = '#';
    }

    if ($work->url_files){
        $arFilesPath = explode(',', $work->url_files);
    }
    if (str_contains($work->url_work, 'https://') ||
        str_contains($work->url_work, 'http://')){
        $link = $work->url_work;
    } else {
        $link = 'https://'.$work->url_work;
    }    
@endphp
@section('content')
    
    <main>
        <div class="container">
            
            <div class="work-detail uk-card uk-card-default" data-id="{{ $work->slug }}">
                <div class="uk-card-media-top">
                    @if (!empty($arFilesPath))
                        <img src="/storage/works/img/{{ trim($arFilesPath[0]) }}">
                    @endif
                </div>
                <div class="uk-card-body">
                    
<<<<<<< Updated upstream
                    <a href="{{ $linkToWorker }}" class="uk-card-badge uk-label">{{ $work->user->name }}</a>
=======
                    <a href="{{ $linkToWorker }}" class="uk-card-badge uk-label">{{ $work->user->fio }}</a>
>>>>>>> Stashed changes
                    <h3 class="uk-card-title">{{ $work->title }}</h3>
                    <a href="{{ $link }}">{{ $work->url_work }}</a>
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

            @if (!empty($arFilesPath))
                <div class="uk-child-width-1-1 uk-child-width-1-2@m uk-child-width-1-3@l uk-margin-medium-top" uk-grid uk-lightbox="animation: slide">
                    @foreach ($arFilesPath as $path)
                        <div>
                            <a class="uk-inline" href="/storage/works/img/{{ trim($path) }}">
                                <img src="/storage/works/img/{{ trim($path) }}" width="1800" height="1200" alt="Поломанна картинка 0-о">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

@endsection