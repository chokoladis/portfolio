@extends('layouts.admin')
@php
    use App\Services\ImageService;
@endphp

@push('styles')
    @vite(['resources/scss/admin/works.scss'])
@endpush

@section('title-content') {{ $work->title }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.works.edit', $work) }}@endsection

@section('content')
     
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.work.update', $work) }}" method="POST" enctype="multipart/form-data">
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
                                <img src="{{ '/storage/works/img/'.trim($filePath) }}" alt="">
                            </div>                                
                        @endforeach
                    </div>
                @endif
                <div class="uk-margin js-upload uk-width-1-1 uk-width-1-4@s" uk-form-custom>
                    
                    <label for="photo">
                        <p>{{ __('Ссылки на картинки/скриншоты') }}</p>
                        <sub class="mt-2 mb-2">{{ __('* Выберите файлы размером не более '.round(ImageService::ACCEPT_FILE_SIZE_MB).' мб')  }}</sub>
                        <input type="file" name="photo[]" id="photo" multiple="multiple" accept="image/*">
                        
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
        </div>
    </section>

@endsection