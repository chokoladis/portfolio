@php
$theme = request()->cookie('theme');
@endphp
<div id="md-menu_edit" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <div class="custom-close-icon uk-modal-close">X</div>
        <form action="" method="POST" id="menu_edit" accept-charset="multipart/form-data">
            <h2 class="uk-modal-title">Форма редактирования</h2>
            
            @csrf
            
            <input type="hidden" name="AJAX" value="Y">
            <input type="hidden" name="id">

            <div class="uk-margin">
                <input class="uk-input" type="text" name="name" placeholder="Название">
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="link" placeholder="Ссылка">
            </div>
            <div class="uk-margin">
                <select class="uk-select" aria-label="Select" name="role">
                    <option >guest</option>
                    <option >user</option>
                    <option >admin</option>
                </select>
            </div>
            <div class="uk-margin">
                <label><input class="uk-radio" type="radio" name="active" value="1" checked>Активная</label>
                <label><input class="uk-radio" type="radio" name="active" value="0">Не активная</label>
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="sort" placeholder="Сортировка">
            </div>
        
            <input class="uk-button {{ $theme == 'dark' ? 'uk-button-default': 'uk-button-secondary' }}" type="submit" id="js_menu_edit_submit" value="Обновить">
        </form>
    </div>
</div>