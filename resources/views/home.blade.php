@extends('layouts.main')

@section('content')
    <main>
        <div class="container">
            <div class="uk-card">
                
                <h2>{{ __('you-portfolio.online - это бесплатный сервис обеспечивающий удобный способ хранения портфолио для учебы, а также поиска работы') }}</h2>

                <div class="mt-3 mb-3">
                    <x-main-slider folder="main-slider"></x-main-slider>
                </div>

            </div>

            на портале you-portfolio.online:

            Расскажите о себе, добавьте лучшие работы, соберите отзывы, настройте страницу и поделитесь веб-портфолио со всем миром
            Заполните анкету для поиска работы


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