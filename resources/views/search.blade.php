@extends('layouts.main')

@section('content')
    <main>
        <div class="container">
            <div class="uk-card">
                <div class="uk-card-title uk-text-center uk-text-small uk-margin-small-top">{{ __('Как пользоваться') }}</div>

                <hr class="uk-divider-icon">

                {{-- {{ dump($result); }} --}}

                @foreach ($result as $paginator => $items)
                    <div>
                        {{ $paginator }}
                        <ul class="uk-list uk-list-large uk-list-divider">
                        @foreach ($items as $item)
                            {{-- <li>{{ dump($item) }}</li> --}}
                            @php dump($item) @endphp
                        @endforeach
                        </ul>
                    </div>
                @endforeach

                <p class="uk-text-warning">{{ __('По текущему запросу ничего не надено') }}</p>
            </div>
        </div>
    </main>
@endsection