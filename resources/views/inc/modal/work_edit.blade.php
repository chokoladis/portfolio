@php
    $theme = request()->cookie('theme');
@endphp
<div id="md-work_edit" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <div class="custom-close-icon uk-modal-close">X</div>
        <form action="" method="POST" id="work_edit" accept-charset="multipart/form-data">
            <h2 class="uk-modal-title">Форма редактирования</h2>
            
            @csrf
            
            <input type="hidden" name="AJAX" value="Y">
            <input type="hidden" name="id">

            <div class="uk-margin">
                <input class="uk-input" type="text" name="title" placeholder="Заголовок">
            </div>
            <div class="uk-margin">
                <textarea class="uk-textarea" name="description" placeholder="Описание"></textarea>
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="url_work" placeholder="Ссылка на сайт">
            </div>
        
            <input class="uk-button {{ $theme == 'dark' ? 'uk-button-default': 'uk-button-secondary' }}" type="submit" id="js_work_edit_submit" value="Обновить">
        </form>
    </div>
</div>