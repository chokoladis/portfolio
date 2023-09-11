<!-- This is the modal -->
<div id="md-menu_add" uk-modal>
    <div class="uk-modal-dialog uk-modal-body ">
        <form action="{{ route('menu.store') }}" method="POST" id="work_create" accept-charset="multipart/form-data">
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
                <label for="#link_active"><input class="uk-radio" type="radio" name="link" id='link_active'>Активная</label>
                <label for="#link_no_active"><input class="uk-radio" type="radio" name="link" id='link_no_active'>Не активная</label>
            </div>
        
            <input class="uk-button uk-button-secondary" type="submit" id="js_link_add" value="Добавить">
            <button class="uk-modal-close uk-button" type="button">Закрыть</button>
        </form>
    </div>
</div>