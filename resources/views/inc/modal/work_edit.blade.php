@php
    $theme = request()->cookie('theme');
@endphp
<div id="md-work_edit" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <div class="custom-close-icon uk-modal-close">X</div>
        <form action="" method="POST" id="work_edit" accept-charset="multipart/form-data">
            <h2 class="uk-modal-title">{{ __('Редактирование работы') }}</h2>
            
            @csrf
            
            <input type="hidden" name="AJAX" value="Y">
            <input type="hidden" name="id">

            <div class="uk-margin">
                <input class="uk-input" type="text" name="title" placeholder="{{ __('Заголовок') }}">
            </div>
            <div class="uk-margin">
                <textarea class="uk-textarea" name="description" placeholder="{{ __('Описание') }}"></textarea>
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="url_work" placeholder="{{ __('Ссылка на сайт') }}">
            </div>
        
            <input class="uk-button uk-button-default" type="submit" id="js_work_edit_submit" value="{{ __('Обновить') }}">
        </form>
    </div>
</div>