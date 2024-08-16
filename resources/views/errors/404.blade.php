@extends('layouts.main')

@section('content')
    <main>
        <div class="container">
            <div class="uk-card text-center mt-5">
                <h3 class="uk-text-warning">{{ __('Дядь, ты уверен что туда хотел попасть') }}?</h3>
                <h1>404</h1>
                <img src="{{ '/storage/general/404.gif' }}" alt="">
            </div>
        </div>
    </main>
@endsection