<div class="uk-width-1-1">
    <form action="{{ route('profile.change_user_info') }}" method="post" accept-charset="multipart/form-data">
        <h2>{{ __('Редактирование основной информации') }}</h2>
        
        @csrf
    
        <div class="uk-margin">
            <input type="text" name="fio" require="true" class="uk-input" autocomplete="name" placeholder="{{ __('ФИО') }}" value="{{ auth()->user()->fio }}">
        </div>
        <div class="uk-margin">
            <input type="password" name="password" class="uk-input" autocomplete="new-password" placeholder="{{ __('Пароль') }}">
        </div>
        <div class="uk-margin">
            <input type="password" name="password_confirmation" class="uk-input" autocomplete="new-password" placeholder="{{ __('Подтверждение пароля') }}">
        </div>
    
        <input type="submit" class="uk-button uk-button-default" id="js_user_update" value="{{ __('Изменить') }}">
    </form>
    <button class="uk-button uk-button-default js-add-worker mt-3" uk-toggle="target: #md-worker_add" type="button">Создать Workers профиль</button>
</div>