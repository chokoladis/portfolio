@php
    $theme = request()->cookie('theme');
@endphp
<div id="md-work_create" uk-modal>
    <div class="uk-modal-dialog uk-modal-body ">
        <div class="custom-close-icon uk-modal-close">X</div>
        <form action="{{ route('work.store') }}" method="POST" id="work_create" accept-charset="multipart/form-data">
            <h2 class="uk-modal-title">Форма добавления</h2>
            
            @csrf
            
            <input type="hidden" name="AJAX" value="Y">

            <div class="uk-margin">
                <input class="uk-input" type="text" name="title" placeholder="Заголовок">
            </div>
            <div class="uk-margin">
                <textarea class="uk-textarea" name="description" placeholder="Описание"></textarea>
            </div>
            <div class="uk-margin">
                <input type="file" name="url_files" multiple="multiple" accept="image/*">
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="url_work" placeholder="Ссылка на сайт">
            </div>
        
            <input class="uk-button {{ $theme == 'dark' ? 'uk-button-default': 'uk-button-secondary' }}" type="submit" id="js_work_add" value="Добавить">
        </form>
    </div>
</div>