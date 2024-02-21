@php
    $theme = request()->cookie('theme');
@endphp
<div id="md-menu_add" uk-modal>
    <div class="uk-modal-dialog uk-modal-body ">
        <div class="custom-close-icon uk-modal-close">X</div>
        <form action="{{ route('menu.store') }}" method="POST" id="menu_add" accept-charset="multipart/form-data">
            <h2 class="uk-modal-title">{{ __('Добавление пункта меню') }}</h2>
            
            @csrf
            
            <input type="hidden" name="AJAX" value="Y">

            <div class="uk-margin">
                <input class="uk-input" type="text" name="name" placeholder="{{ __('Название') }}">
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="link" placeholder="{{ __('Ссылка') }}">
            </div>
            <div class="uk-margin">
                <select class="uk-select" aria-label="Select" name="role">
                    <option >guest</option>
                    <option >user</option>
                    <option >admin</option>
                </select>
            </div>
            <div class="uk-margin">
                <label><input class="uk-radio" type="radio" name="active" value="1" checked>{{ __('Активная') }}</label>
                <label><input class="uk-radio" type="radio" name="active" value="0">{{ __('Не активная') }}</label>
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="text" name="sort" placeholder="{{ __('Сортировка') }}">
            </div>
        
            <input class="uk-button uk-button-default" type="submit" id="js_link_add" value="{{ __('Добавить') }}">
        </form>
    </div>
</div>