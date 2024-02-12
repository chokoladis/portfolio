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
            <section class="worker-work-edit">
                <form action="{{ route('profile.works.update', $work) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    @php 
                        $columns = $work->getColumns(); 
                        $arFiles = $work->url_files ? explode(',', $work->url_files) : [];
                        $model = $work;
                    @endphp
                    
                    @include('compiled.admin.form')

                    @if (!empty($arFiles))
                        <div class="uk-child-width-1-1 uk-child-width-1-3@m uk-child-width-1-4@l">
                            @foreach ($arFiles as $key => $filePath)
                                <label for="url_files[{{ $key }}]">
                                    <input type="checkbox" name="url_files" id="url_files[{{ $key }}]" class="uk-checkbox" checked>{{ __('Картинка - '.$key) }}
                                    <img src="{{ '/storage/works/img/'.trim($filePath) }}" alt="">
                                </label>
                            @endforeach
                        </div>
                    @endif
                    <div class="uk-margin js-upload" uk-form-custom>
                        <label for="photo">
                            {{ __('Ссылки на картинки/скриншоты') }}
                            <input type="file" name="photo" id="photo" multiple accept="image/*">
                            <button class="uk-button uk-button-default" type="button" tabindex="-1">Добавить</button>
                        </label>                        

                        @if($errors->has('photo'))
                            <div class="error">{{ $errors->first('photo') }}</div>
                        @endif
                    </div>
                
                    <div class="buttons">
                        <input type="submit" value="{{ __('Изменить') }}" class="uk-button uk-button-default">
                    </div>
                    {{-- <a href="{{ route('profile.works.files.store', $work ) }}" class="uk-button uk-button-primary">{{ __('Добавить/Изменить файлы') }}</a> --}}
                </form>     
            </section>
        </div>
    </main>

@endsection