
@php
    $theme = $_COOKIE['theme'];
@endphp
<div id="md-worker_new" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <div class="custom-close-icon uk-modal-close">X</div>
        <form action="" method="POST" id="worker_new" accept-charset="multipart/form-data">
            <h2 class="uk-modal-title">Форма создания</h2>
            
            @csrf
            
            <input type="hidden" name="AJAX" value="Y">

            <div class="uk-margin">
                <label for="">
                    <div class="uk-button">Вставьте ваше фото</div>
                    <input type="file" name="url_avatar" accept="image/*">
                </label>                
            </div>
            <div class="uk-margin">
                <input class="uk-input" name="phone" placeholder="Телефон">
            </div>
            <div class="uk-margin">
                <textarea class="uk-textarea" name="about" placeholder="Текст о вас"></textarea>
            </div>
            <div class="uk-margin socials">
                <h4 class='uk-heading-bullet'>Ссылки</h4>
                <div class="links uk-child-width-1-2@s uk-child-width-1-1">
                    <label for="socials">
                        <img src="/storage/general/links/telegram.svg" alt="telegram"> 
                        <input class="uk-input" name="socials" id="socials_telegram" placeholder="telegram">
                    </label>
                    <label for="#socials_github">
                        <span uk-icon="icon: github; ratio:2;"></span>
                        <input class="uk-input" name="socials" id="socials_github" placeholder="github">
                    </label>
                    <label for="">
                        <!-- <img src="" alt=""> vk -->
                        <input class="uk-input" name="socials" id="socials_hh_ru" placeholder="hh.ru">
                    </label>
                    <label for="">
                        <!-- <img src="" alt=""> vk -->
                        <input class="uk-input" name="socials" id="socials_kwork" placeholder="kwork.ru">
                    </label>
                </div>
                
            </div>
        
            <input class="uk-button {{ $theme == 'dark' ? 'uk-button-default': 'uk-button-secondary' }}" type="submit" id="js_work_edit_submit" value="Обновить">
        </form>
    </div>
</div>