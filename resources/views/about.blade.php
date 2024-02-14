@extends('layouts.main')

@section('content')
    <main>
        <div class="container">
            <div class="uk-card">
                <div class="uk-card-title uk-text-center uk-text-small uk-margin-small-top">{{ __('Как пользоваться') }}</div>

                <hr class="uk-divider-icon">
                <h2>Раздел <a href="{{ route('work.index') }}">"Работы"</a></h2>

                {{-- <p class="uk-text-warning">{{ __('Данный сервис будет давать возможность разместить своё портфолио и работы') }}</p> --}}
            </div>
        </div>
    </main>
@endsection