@extends('layouts.main')

@section('content')
    <main>
        <div class="container">
            <div class="uk-card">
                <div class="uk-card-title uk-text-center uk-text-small uk-margin-small-top">{{ __('Как пользоваться') }}</div>

                <hr class="uk-divider-icon">
                <div class="mb-4">
                    <h2>{{ __('Раздел') }} <a href="{{ route('work.index') }}">{{ __('"Работы"') }}</a></h2>
                    <p>{{ __('В этом разделе вы можете просматривать, оставленные зарегестрированными пользователями, примеры цифровых работ') }}</p>
                </div>
                <div class="mb-4">
                    <h2>{{ __('Раздел') }} <a href="{{ route('workers.index') }}">{{ __('"Профили"') }}</a></h2>
                    <sub class="text-warning">{{ __('Доступен только для авторизированных') }}</sub>
                    <p>{{ __('В этом разделе список зарегестрированных профилей, которые ищут работу') }}</p>
                </div>

                <div class="mb-4">
                    <h4>{{ __('Также есть страница') }} <a href="{{ route('search', ['search' => 'test']) }}">{{ __('поиска') }}</a></h4>
                </div>

            </div>
        </div>
    </main>
@endsection