@php
    $theme = request()->cookie('theme');
@endphp
<div id="md-work_add" uk-modal>
    <div class="uk-modal-dialog uk-modal-body ">
        <div class="custom-close-icon uk-modal-close">X</div>
        <form action="{{ route('work.store') }}" method="POST" id="work_add" accept-charset="multipart/form-data">
            <h2 class="uk-modal-title">{{ __('Добавление работы') }}</h2>
            
            @csrf
            
            <input type="hidden" name="AJAX" value="Y">

            <div class="uk-margin">
                <input class="uk-input" type="text" name="title" placeholder="{{ __('Заголовок') }}">
            </div>
            <div class="uk-margin">
                <textarea class="uk-textarea" name="description" placeholder="{{ __('Описание') }}"></textarea>
            </div>
            <div class="uk-margin">
                <input type="file" name="url_files" multiple="multiple">
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="url_work" placeholder="{{ __('Ссылка на сайт') }}">
            </div>
        
            <input class="uk-button uk-button-default" type="submit" id="js_work_add" value="{{ __('Создать') }}">
        </form>
    </div>
</div>