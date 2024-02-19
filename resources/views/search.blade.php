@extends('layouts.main')


@section('breadcrumb'){{ Breadcrumbs::render('search', htmlspecialchars(request('search')) ) }}@endsection

@section('page.title'){{ __('Поиск по запросу - '). htmlspecialchars(request('search')) }}@endsection

@push('styles')
    @vite(['resources/scss/search.scss'])
@endpush

@section('content')

    @if ($total_count)
        <header class="header-filter">
            <div class="container">
                <form action="{{ route('search') }}" method="GET" id="search-filter">

                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="page" value="{{ request('page') ?? 1 }}">

                    <ul class="one-row ">
                        <li class="filter">
                            <div class="btn">
                                <span uk-icon="settings"></span>
                            </div>
                            <div class="inputs">
                                <select name="orderBy" value="{{ request('orderBy') }}" >
                                    <option value="" disabled selected>Сортировка</option>
                                    <option value="views">По просмотрам</option>
                                    <option value="created_at">По дате добавления</option>
                                </select>
                                <select name="sort">
                                    <option value="asc" selected>По возрастанию</option>
                                    <option value="desc">По убыванию</option>
                                </select>
                            </div>
                        </li>
                        <input type="submit" value="Поиск" class="uk-button uk-button-default">
                    </ul>
                </form>
            </div>
        </header>
    @endif

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
                                    <div class="addition_info">
                                        <div class="date">
                                            {{ $item['date_insert']->format('d.m.Y H:i') }} 
                                        </div>
                                        <span class="splash">|</span>
                                        <div class="views">
                                            <span uk-icon="eye"></span> {{ rand(1,250) }}
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                            </ul>
                        </div>
                    @endforeach

                    @if($pages > 1)
                        <nav class="d-flex justify-items-center justify-content-between">
                            <div class="d-flex justify-content-between flex-fill">
                                <ul class="pagination">

                                @php
                                    $i = 1;
                                    // $pages = 20;
                                    $current = request('page') ? intval(request('page')) : 1;

                                    $i_right = $current + 5;
                                    $i_left = $current - 5;

                                    @endphp
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('search', ['search' => request('search'), 'page' => 1]) }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                                        </li>
                                    @php

                                    while ($pages >= $i) {                        
                                                                                        
                                        if ($i == $current){ @endphp
                                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                                        @php } elseif ($i < $i_right && $i > $i_left) { @endphp
                                            <li class="page-item"><a class="page-link" href="{{ route('search', ['search' => request('search'), 'page' => $i]) }}">{{ $i }}</a></li>
                                        @php }

                                        $i++;
                                    }
                                    
                                    @endphp
                                    <li class="page-item">
                                        <a class="page-link" href="{{ route('search', ['search' => request('search'), 'page' => $pages]) }}" rel="next">&rsaquo;</a>
                                    </li>
                                    @php
                                @endphp
                                
                                </ul>
                            </div>
                        </nav>
                    @endif
        

                @else
                    <p class="uk-text-warning">{{ __('По текущему запросу ничего не надено') }}</p>
                @endif
                
            </div>
        </div>
    </main>
@endsection