@extends('layouts.main')

@section('content')
    <main>
        <div class="container">
            <div class="uk-card">
                <div class="uk-card-title uk-text-center uk-text-small uk-margin-small-top">{{ __('Как пользоваться') }}</div>

                <hr class="uk-divider-icon">
                <h2>Раздел <a href="{{ route('work.index') }}">"Работы"</a></h2>

                {{-- <p class="uk-text-warning">{{ __('Данный сервис будет давать возможность разместить своё портфолио и работы') }}</p> --}}
                
                <a href="https://github.com/chokoladis/" uk-icon="icon: github; ratio:2;"></a>

                <i>{{ __('Сайт разработан на свободное время какого то разработчика с ником ') }}<b>chokoladis</b></i>
            </div>
        </div>
    </main>
@endsection