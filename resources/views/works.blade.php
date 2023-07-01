@extends('layout.main')

@section('content')
    
    @foreach($works as $work)
        <div class="work">
            <h3>{{  $work->title  }}</h3>
            <p>{{  $work->description  }}</p>
            <a href="{{ $work->url_work }}">{{ $work->url_work }}</a>
            <!-- <h3>{{  $work->title  }}</h3> -->
        </div>
    @endforeach
@endsection