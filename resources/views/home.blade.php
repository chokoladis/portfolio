@extends('layouts.main')

@section('content')
    <main>
        <div class="container">
            <div class="uk-card">
                <div class="uk-card-title uk-text-center uk-text-small uk-margin-small-top">{{ __('Wellcome') }}</div>

                <hr class="uk-divider-icon">
                <h2>{{ __('Это бесплатный сайт-проект обычного работяги') }}</h2>
                <p class="uk-text-warning">{{ __('Данный сервис будет давать возможность разместить своё портфолио и работы') }}</p>
            </div>
            <div class="uk-card">
                <div class="uk-card-title uk-text-center uk-text-small uk-margin-small-top">{{ __('Как пользоваться') }}</div>

                <hr class="uk-divider-icon">
                <div class="mb-4">
                    <h2>{{ __('Раздел') }} <a href="{{ route('work.index') }}">{{ __('"Работы"') }}</a></h2>
                    <p>{{ __('Создан для просмотра работ оставленных на сайте') }}</p>
                </div>
                <div class="mb-4">
                    <h2>{{ __('Раздел') }} <a href="{{ route('workers.index') }}">{{ __('"Профили"') }}</a></h2>
                    <sub class="text-warning">{{ __('Доступен для подтвердивших почту') }}</sub>
                    <p>{{ __('Список зарегестрированных профилей') }}</p>
                </div>

                <div class="mb-4">
                    <h4>{{ __('Также есть страница') }} <a href="{{ route('search', ['search' => 'test']) }}">{{ __('поиска') }}</a></h4>
                </div>

            </div>
        </div>
    </main>
@endsection