@extends('layout.main')

@section('content')
    
    @foreach($works as $work)
        <div class="work" data-id="{{ $work->id }}">
            <!-- <div class="border"></div> -->
            <div class="content">
                <h3>{{  $work->title  }}</h3>
                <p>{{  $work->description  }}</p>
                <a href="{{ $work->url_work }}">{{ $work->url_work }}</a>
                <!-- <h3>{{  $work->title  }}</h3> -->
            </div>
            <div class="work_actions">
                <div class="work_actions btn btn_delete">Х</div>
            </div>
        </div>
    @endforeach

    <button class="uk-button uk-button-default" uk-toggle="target: #md-work_create" type="button">Добавить</button>

@endsection

@include('inc.modal.works_create')