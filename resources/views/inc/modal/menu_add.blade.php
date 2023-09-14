<!-- This is the modal -->
<div id="md-menu_add" uk-modal>
    <div class="uk-modal-dialog uk-modal-body ">
        <form action="{{ route('menu.store') }}" method="POST" id="menu_add" accept-charset="multipart/form-data">
            <h2 class="uk-modal-title">Форма добавления</h2>
            
            @csrf
            
            <input type="hidden" name="AJAX" value="Y">

            <div class="uk-margin">
                <input class="uk-input" type="text" name="name" placeholder="Название">
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="link" placeholder="Ссылка">
            </div>
            <div class="uk-margin">
                <select class="uk-select" aria-label="Select" name="role">
                    <option >user</option>
                    <option >admin</option>
                </select>
            </div>
            <div class="uk-margin">
                <label><input class="uk-radio" type="radio" name="active" value="1" checked>Активная</label>
                <label><input class="uk-radio" type="radio" name="active" value="0">Не активная</label>
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="sort" placeholder="Сортировка" value="100">
            </div>
        
            <input class="uk-button uk-button-secondary" type="submit" id="js_link_add" value="Добавить">
            <button class="uk-modal-close uk-button" type="button">Закрыть</button>
        </form>
    </div>
</div>