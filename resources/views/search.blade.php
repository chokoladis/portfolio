@php
    use App\Http\Controllers\HelperController;
@endphp
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

                    <ul class="active">
                        <li class="filter active">
                            <div class="btn">
                                <span uk-icon="settings"></span>
                            </div>
                            <div class="inputs">
                                <select name="orderBy" class="uk-select" aria-label="Select">
                                    <option value="" disabled selected>Сортировка</option>
                                    @php
                                        foreach (HelperController::ORDER_BY as $code => $value) {
                                            $sel = $code === request('orderBy') ? 'selected' : '';
                                            echo '<option value="'.$code.'" '.$sel.'>'.$value.'</option>';
                                        }                                        
                                    @endphp
                                </select>
                                <select name="sort" class="uk-select" aria-label="Select">
                                    @php
                                        foreach (HelperController::SORT as $code => $value) {
                                            $sel = $code === request('sort') ? 'selected' : '';
                                            echo '<option value="'.$code.'" '.$sel.'>'.$value.'</option>';
                                        }                                        
                                    @endphp
                                </select>
                            </div>
                        </li>
                        <input type="submit" value="Применить" class="uk-button uk-button-default">
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
                                                <p>"{{ trans('crud.'.$model.'.search.'.$code) }}" - <b>{{ $value }}</b></p>                                                
                                            </div>
                                        @endforeach

                                    </div>
                                    <div class="addition_info">
                                        <div class="date">
                                            {{ $item['date_insert']->diffForHumans() }}
                                        </div>
                                        <span class="splash">|</span>
                                        <div class="views">
                                            <span uk-icon="eye"></span> {{ $item['views'] ?? '-' }}
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                            </ul>
                        </div>
                    @endforeach

                    <nav class="d-flex justify-items-center justify-content-between">
                        <div class="d-flex flex-fill">

                            <select name="per_page" class="me-3">
                                @php
                                    $perPage = request('per_page') ?? 5;
            
                                    $list = HelperController::PER_PAGE;
            
                                    foreach ($list as $count) {
            
                                        $select = $perPage == $count ? 'selected' : '';
            
                                        echo "<option $select>$count</option>";
                                    }
                                @endphp
                            </select>

                            @if($pages > 1)
                                <ul class="pagination">

                                    @php
                                        $i = 1;
                                        $orderBy = request('orderBy');
                                        $sort = request('sort');
                                        $current = request('page') ? intval(request('page')) : 1;
                                        $params = ['search' => request('search'), 'page' => 1];

                                        if ($orderBy)
                                            $params = array_merge($params, ['orderBy' => $orderBy]);
                                        if ($sort)       
                                            $params = array_merge($params, ['sort' => $sort]);

                                        $i_right = $current + 5;
                                        $i_left = $current - 5;

                                        @endphp
                                            <li class="page-item">
                                                <a class="page-link" href="{{ route('search', $params) }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                                            </li>
                                        @php

                                        while ($pages >= $i) {                        
                                                                                            
                                            if ($i == $current){ @endphp
                                                <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                                            @php } elseif ($i < $i_right && $i > $i_left) {
                                                $params['page'] = $i; 
                                                @endphp
                                                <li class="page-item"><a class="page-link" href="{{ route('search', $params) }}">{{ $i }}</a></li>
                                            @php }

                                            $i++;
                                        }
                                        
                                        $params['page'] = $pages; 

                                        @endphp
                                        <li class="page-item">
                                            <a class="page-link" href="{{ route('search', $params) }}" rel="next">&rsaquo;</a>
                                        </li>
                                        @php
                                    @endphp
                                
                                </ul>
                            @endif
                        
                        </div>
                    </nav>

                @else
                    <p class="uk-text-warning">{{ __('По текущему запросу ничего не надено') }}</p>
                @endif
                
            </div>
        </div>
    </main>
@endsection