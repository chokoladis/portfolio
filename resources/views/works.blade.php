@extends('layout.main')

@section('content')
    
    @include('compiled.works')

    <button class="uk-button uk-button-default" uk-toggle="target: #md-work_create" type="button">Добавить</button>
@endsection

@include('inc.modal.work_create')