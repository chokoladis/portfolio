@extends('layouts.admin')

@section('title-content') {{ __('Категории - добавить') }} @endsection

@section('breadcrumb'){{ Breadcrumbs::render('admin.category.create') }}@endsection

@push('scripts')
    @vite(['resources/js/admin/categories.js'])
@endpush

@section('content')

    <section class="content">
        <div class="container-fluid">

            <form action="{{ route('admin.categories.store') }}" method="POST" id="category_store" enctype="multipart/form-data">

                @csrf

                <x-forms.select title="Сущность" field="entity_code" :values='$entities' />

                @if(!empty($categories))
                    <x-forms.select title="Родительская категория" field="parent_id" :values='$categories' />
                @endif

                <x-forms.input title="Название" field="name" type="text" />
                <x-forms.input title="Символьный код" field="code" type="text" />
                <x-forms.input title="Сортировка" field="sort" type="number" />
                <x-forms.input title="Активность" field="active" type="checkbox" checked="checked" />

                <x-forms.input title="Иконка" field="preview" type="file" />

                <input class="uk-button uk-button-primary" type="submit" value="{{ __('Добавить') }}">
            </form>

        </div>
    </section>

@endsection
