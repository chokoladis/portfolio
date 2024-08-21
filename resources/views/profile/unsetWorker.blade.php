<div class="uk-width-1-1">
    <form action="{{ route('profile.change_user_info') }}" method="post" accept-charset="multipart/form-data">
        <h2>{{ __('Редактирование основной информации') }}</h2>
        
        @csrf

        {{-- <input type="hidden" name="AJAX" value="Y"> --}}
    
        <div class="uk-margin">
            <input type="text" name="fio" require="true" autocomplete="name" placeholder="{{ __('ФИО') }}" 
                class="@error('fio') uk-form-danger @enderror uk-input" value="{{ old('fio') ?? auth()->user()->fio }}">

            @error('fio')
                <span class="uk-text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="uk-margin">
            <input type="password" name="password" autocomplete="new-password" placeholder="{{ __('Пароль') }}"
                class="uk-input @error('password') uk-form-danger @enderror" value="{{ old('password') }}">

            @error('password')
                <span class="uk-text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="uk-margin">
            <input type="password" name="password_confirmation" autocomplete="new-password" placeholder="{{ __('Подтверждение пароля') }}"
                class="uk-input @error('password') uk-form-danger @enderror">
        </div>

        <input type="submit" class="uk-button uk-button-default" id="js_user_update" value="{{ __('Изменить') }}">
    </form>
    <button class="uk-button uk-button-default js-add-worker mt-3" uk-toggle="target: #md-worker_add" type="button">Создать Workers профиль</button>
</div>