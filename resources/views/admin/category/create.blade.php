@extends('layouts.admin')

@section('title-content') {{ __('Категории - добавить') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.category.create') }}@endsection

@section('content')

    <section class="content">
        <div class="container-fluid">

            <form action="{{ route('admin.categories.store') }}" method="POST">

                @csrf

                <x-forms.select title="Сущность" field="entity_code" :values='$entities' />

{{--                ajax при изменении ентити и кэширование --}}
                @if(!empty($categories))
                    <x-forms.select title="Родительская категория" field="parent_id" :values='$categories' />
                @endif

                <x-forms.input title="Название" field="name" type="text" />
                <x-forms.input title="Символьный код" field="code" type="text" />
                <x-forms.input title="Активность" field="active" type="checkbox" checked="checked" />

                <x-forms.input title="Иконка" field="preview" type="file" />

                <input class="uk-button uk-button-primary" type="submit" value="{{ __('Добавить') }}">
            </form>

        </div>
    </section>


@endsection
