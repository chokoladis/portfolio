@extends('layouts.admin')
@php
    use App\Services\FileService;
@endphp

@push('styles')
    @vite(['resources/scss/admin/works.scss'])
@endpush

@section('title-content') {{ $work->title }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.works.edit', $work) }}@endsection

@section('content')
     
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.works.update', $work) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @php 
                    $columns = $work->getColumns();
                    $arFiles = $work->url_files ? explode(',', $work->url_files) : [];
                    $model = $work;
                @endphp
            
                @include('compiled.admin.form')

                @if (!empty($arFiles))
                    <div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l f_url_files">
                        @foreach ($arFiles as $key => $filePath)
                            <div>
                                <label>
                                    <input type="checkbox" name="url_files_flags[{{ $key }}]" class="uk-checkbox" checked>
                                    <span>{{ __('Картинка - '.$key+1) }}</span>
                                </label>
                                <input type="hidden" name="url_files[{{ $key }}]" value="{{ trim($filePath) }}">

                                @if (is_image($filePath))
                                    <img src="{{ config('filesystems.clients.works').trim($filePath) }}" alt="Поломанна картинка 0-о">
                                @elseif (is_video($filePath))
                                    <video src="{{ config('filesystems.clients.works').trim($filePath) }}" controls preload="none"></video>
                                @else
                                    <b>Файл - {{ config('filesystems.clients.works').trim($filePath) }}</b>
                                @endif
                            </div>                                
                        @endforeach
                    </div>
                @endif
                <div class="uk-margin js-upload uk-width-1-1 uk-width-1-4@s" uk-form-custom>
                    
                    <label for="photo">
                        <p>{{ __('Ссылки на картинки/скриншоты') }}</p>
                        <sub class="mt-2 mb-2">{{ __('* Выберите файлы размером не более '.round(FileService::ACCEPT_FILE_SIZE_MB).' мб')  }}</sub>
                        <input type="file" name="photo[]" id="photo" multiple="multiple">
                        
                        <button class="uk-button uk-button-small uk-button-upload" type="button" tabindex="-1">{{ __('Добавить') }}</button>
                    </label>

                    @if($errors->has('photo'))
                        <div class="error">{{ $errors->first('photo') }}</div>
                    @endif
                </div>
            
                <div class="buttons">
                    <input type="submit" value="{{ __('Изменить') }}" class="uk-button uk-button-default">
                </div>
                    
            </form>

            <x-model-additional :model="$work" crud="Example_work" new_line="true"></x-model-additional>
        </div>
    </section>

@endsection