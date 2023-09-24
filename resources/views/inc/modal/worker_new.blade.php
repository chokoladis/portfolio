
<!-- This is the modal -->
<div id="md-worker_new" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
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
            <div class="uk-margin">
                <label for="">
                    <img src="/storage/general/links/telegram.svg" alt="telegram"> 
                    <input class="uk-input" name="socials" id="socials_telegram" placeholder="telegram">
                </label>
                <label for="">
                    <img src="/storage/general/links/github.svg" alt="github" uk-icon="icon: github; ratio:2;"> 
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
        
            <input class="uk-button uk-button-secondary" type="submit" id="js_work_edit_submit" value="Обновить">
            <button class="uk-modal-close uk-button" type="button">Закрыть</button>
        </form>
    </div>
</div>