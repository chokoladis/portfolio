@extends('layouts.main')

@section('content')
    <main>
        <div class="container">
            <div class="uk-card">
                <div class="uk-card-title uk-text-center uk-text-small uk-margin-small-top">{{ __('Как пользоваться') }}</div>

                <hr class="uk-divider-icon">
                
                {{ dump($result); }}
                <p class="uk-text-warning">{{ __('По текущему запросу ничего не надено') }}</p>
            </div>
        </div>
    </main>
@endsection