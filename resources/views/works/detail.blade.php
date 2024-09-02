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
    if($worker = $work?->user?->workers){
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

    foreach ($arFilesPath as $path) {
        if (is_image($path)){
            $cover = config('filesystems.clients.Example_work').trim($path);
            break;
        }
    }

    $cover = $cover ?? '';


@endphp
@section('content')
    
    <main class="work-detail">
        <div class="container">
            
            <div class="uk-card uk-card-default" data-id="{{ $work->slug }}">
                <div class="uk-card-media-top">
                    @if (!empty($cover))
                        <img src="{{ $cover }}">
                    @endif
                </div>
                <div class="uk-card-body">
                    <a href="{{ $linkToWorker }}" class="uk-card-badge uk-label">{{ $work->user?->fio ?? '*no-user*' }}</a>
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
                <div class="work-files uk-child-width-1-1 uk-child-width-1-2@m uk-child-width-1-3@l uk-margin-medium-top" uk-grid uk-lightbox="animation: slide">
                    @foreach($arFilesPath as $path)
                        <div>
                            <a class="uk-inline" href="{{ config('filesystems.clients.Example_work').trim($path) }}">
                                @if (is_image($path))
                                    <img src="{{ config('filesystems.clients.Example_work').trim($path) }}" width="1800" height="1200" alt="Поломанна картинка 0-о">
                                @elseif (is_video($path))
                                    <video src="{{ config('filesystems.clients.Example_work').trim($path) }}" controls preload="none"></video>
                                @else
                                    <b>Файл - {{ config('filesystems.clients.Example_work').trim($path) }}</b>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

@endsection