@extends('layout.admin')

@section('content')
    @include('compiled.works')

    <button class="uk-button uk-button-primary" uk-toggle="target: #md-work_create" type="button">Добавить</button>
@endsection