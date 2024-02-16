@extends('layouts.main')


@section('breadcrumb'){{ Breadcrumbs::render('search', htmlspecialchars(request('search')) ) }}@endsection

@section('page.title'){{ __('Поиск по запросу - '). htmlspecialchars(request('search')) }}@endsection

@push('styles')
    @vite(['resources/scss/search.scss'])
@endpush

@section('content')
    <main>
        <div class="container">
            <div class="uk-card">
                <div class="uk-card-title uk-text-center uk-text-small uk-margin-small-top">{{ __('Поиск по запросу - '). htmlspecialchars(request('search'))  }}</div>

                <hr class="uk-divider-icon">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($total_count)

                    @foreach ($result as $model => $arModel)
                        <div class="uk-margin">
                            <h3 class="uk-heading-bullet">{{ $arModel['title'] }}</h3>
                            <ul class="uk-list uk-list-large uk-list-striped">

                            @foreach ($arModel['items'] as $item)
                                <li>
                                    <a href="{{ $item['route'] }}">{{ $item['html_title'] }}</a>
                                    <div class="contain">

                                        <span>{{ __('Найдено в') }}</span>
                                        @foreach($item['contents'] as $code => $value)
                                            <div class="uk-flex">
                                                <p>"{{ trans('crud.'.$model.'.fields.'.$code) }}" - <b>{{ $value }}</b></p>                                                
                                            </div>
                                        @endforeach

                                    </div>
                                </li>
                            @endforeach

                            </ul>
                        </div>
                    @endforeach

                @else
                    <p class="uk-text-warning">{{ __('По текущему запросу ничего не надено') }}</p>
                @endif
                
            </div>
        </div>
    </main>
@endsection