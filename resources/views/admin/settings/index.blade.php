@extends('layouts.admin')

@section('title-content') {{ __('Настройки') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.setting') }}@endsection

@section('content')

    <section class="content">
        <div class="container-fluid">

            <div class="setting-block">

                <h1 class="uk-heading-line"><span>{{ __('Кэш') }}</span></h1>

                <div class="body">
                    <button href="{{ route('admin.settings.cache.clearAll') }}" class="uk-button uk-button-danger">{{ __('Очистить весь кэш') }}</button>
                </div>
            </div>

        </div>
    </section>


@endsection
