@extends('layouts.admin')
@php
    use App\Services\ImageService;
@endphp

@push('styles')
    @vite(['resources/scss/admin/works.scss'])
@endpush

@section('title-content') {{ $worker->name }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.workers.edit', $worker) }}@endsection

@section('content')
     
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.workers.update', $worker) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @php 
                    $columns = $worker->getColumns();
                    $file = $worker->url_avatar;
                    $model = $worker;
                @endphp

                <div class="current_avatar">
                    <img src="{{ $file }}" alt="">
                </div>

                <div class="uk-margin js-upload uk-width-1-1 uk-width-1-4@s">
                                    
                    <label>
                        <p>{{ __('Аватарка') }}</p>
                        <sub class="mt-2 mb-2">{{ __('* Выберите файлы размером не более '.round(ImageService::ACCEPT_FILE_SIZE_MB).' мб')  }}</sub>
                        <input type="file" name="photo" accept="image/*">
                        
                        <button class="uk-button uk-button-small uk-button-upload" type="button" tabindex="-1">{{ __('Добавить') }}</button>
                    </label>

                    @if($errors->has('photo'))
                        <div class="error">{{ $errors->first('photo') }}</div>
                    @endif
                </div>
            
                @include('compiled.admin.form')
            
                <div class="buttons">
                    <input type="submit" value="{{ __('Изменить') }}" class="uk-button uk-button-default">
                </div>
                    
            </form>
        </div>
    </section>

@endsection