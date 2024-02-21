
@php
    $theme = request()->cookie('theme');
@endphp
<div id="md-worker_add" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <div class="custom-close-icon uk-modal-close">X</div>
        <form action="{{ route('workers.store') }}" method="POST" id="worker_add" accept-charset="multipart/form-data">
            <h2 class="uk-modal-title">{{ __('Создание профиля') }}</h2>
            
            @csrf
            
            <input type="hidden" name="AJAX" value="Y">

            <div class="uk-margin">
                <label class="photo">
                    <div class="uk-button uk-button-primary">{{ __('Вставьте аватарку') }}</div>
                    <p class="uk-hidden"></p>
                    <input type="file" name="photo" accept="image/*">
                </label>                
            </div>
            <div class="uk-margin">
                <input class="uk-input js-phone-mask" name="phone" require="true" autocomplete="tel" placeholder="{{ __('Телефон') }}">
            </div>
            <div class="uk-margin">
                <textarea class="uk-textarea" name="about" autocomplete="on" placeholder="{{ __('Текст о вас') }}"></textarea>
            </div>
            <div class="uk-margin socials">
                <h4 class='uk-heading-bullet'>{{ __('Ссылки') }}</h4>
                <div class="links uk-child-width-1-2@s uk-child-width-1-1">
                    <label>
                        <img src="/storage/general/links/telegram.svg" alt="telegram"> 
                        <input class="uk-input" name="socials" id="telegram" placeholder="@nickname / t.me/...">
                    </label>
                    <label>
                        <img src="/storage/general/links/github.svg" alt="github"> 
                        <input class="uk-input" name="socials" id="github" placeholder="nickname / github.com/... ">
                    </label>
                    <label>
                        <img src="/storage/general/links/hh.png" alt="hh.ru">
                        <input class="uk-input" name="socials" id="hh" placeholder="https://moskow.hh.ru/resume/8960a5...">
                    </label>
                    <label>
                        <img src="/storage/general/links/kwork.png" alt="kwork.com">
                        <input class="uk-input" name="socials" id="kwork" placeholder="https://kwork.ru/user/...">
                    </label>
                </div>
                
            </div>
        
            <input class="uk-button uk-button-default" type="submit" id="js_workers_add_submit" value="{{ __('Создать') }}">
        </form>
    </div>
</div>