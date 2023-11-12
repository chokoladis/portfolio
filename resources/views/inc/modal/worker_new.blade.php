
@php
    $theme = request()->cookie('theme');
@endphp
<div id="md-worker_new" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <div class="custom-close-icon uk-modal-close">X</div>
        <form action="{{ route('workers.store') }}" method="POST" id="worker_new" accept-charset="multipart/form-data">
            <h2 class="uk-modal-title">Форма создания</h2>
            
            @csrf
            
            <input type="hidden" name="AJAX" value="Y">

            <div class="uk-margin">
                <label class="photo">
                    <div class="uk-button uk-button-primary">Вставьте ваше фото</div>
                    <p class="uk-hidden"></p>
                    <input type="file" name="photo" accept="image/*">
                </label>                
            </div>
            <div class="uk-margin">
                <input class="uk-input js-phone-mask" name="phone" require="true" autocomplete="tel" placeholder="Телефон">
            </div>
            <div class="uk-margin">
                <textarea class="uk-textarea" name="about" autocomplete="on" placeholder="Текст о вас"></textarea>
            </div>
            <div class="uk-margin socials">
                <h4 class='uk-heading-bullet'>Ссылки</h4>
                <div class="links uk-child-width-1-2@s uk-child-width-1-1">
                    <label>
                        <img src="/storage/general/links/telegram.svg" alt="telegram"> 
                        <input class="uk-input" name="socials" id="telegram" placeholder="telegram">
                    </label>
                    <label>
                        <img src="/storage/general/links/github.svg" alt="github"> 
                        <input class="uk-input" name="socials" id="github" placeholder="github">
                    </label>
                    <label>
                        <img src="/storage/general/links/hh.png" alt="hh.ru">
                        <input class="uk-input" name="socials" id="hh_ru" placeholder="hh.ru">
                    </label>
                    <label>
                        <img src="/storage/general/links/kwork.png" alt="kwork.com">
                        <input class="uk-input" name="socials" id="kwork" placeholder="kwork.com">
                    </label>
                </div>
                
            </div>
        
            <input class="uk-button {{ $theme == 'dark' ? 'uk-button-default': 'uk-button-secondary' }}" type="submit" id="js_workers_add_submit" value="Создать">
        </form>
    </div>
</div>