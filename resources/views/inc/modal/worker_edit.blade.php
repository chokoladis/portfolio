
@php
    $theme = request()->cookie('theme');
    $socials = json_decode($worker->socials, 1);
@endphp
<div id="md-worker_edit" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <div class="custom-close-icon uk-modal-close">X</div>
        <form action="{{ route('profile.update') }}" method="POST" id="worker_edit" accept-charset="multipart/form-data">
            <h2 class="uk-modal-title">Форма редактирования</h2>

            @csrf

            <div class="uk-margin">
                <input class="uk-input js-phone-mask" name="phone" require="true" autocomplete="tel" placeholder="Телефон" value="{{ $worker->phone }}">
            </div>
            <div class="uk-margin">
                <textarea class="uk-textarea" name="about" autocomplete="on" placeholder="Текст о вас">{{ $worker->about }}</textarea>
            </div>
            <div class="uk-margin socials">
                <h4 class='uk-heading-bullet'>Ссылки</h4>
                <div class="links uk-child-width-1-2@s uk-child-width-1-1">
                    <label class="{{ isset($socials['telegram']) ? 'fill' : '' }}">
                        <img src="/storage/general/links/telegram.svg" alt="telegram"> 
                        <input class="uk-input" name="socials" id="telegram" placeholder="telegram" value="{{ $socials['telegram'] ?? '' }}">
                    </label>
                    <label class="{{ isset($socials['github']) ? 'fill' : '' }}">
                        <img src="/storage/general/links/github.svg" alt="github"> 
                        <input class="uk-input" name="socials" id="github" placeholder="github" value="{{ $socials['github'] ?? '' }}">
                    </label>
                    <label class="{{ isset($socials['hh']) ? 'fill' : '' }}">
                        <img src="/storage/general/links/hh.png" alt="hh.ru">
                        <input class="uk-input" name="socials" id="hh" placeholder="hh.ru" value="{{ $socials['hh'] ?? '' }}">
                    </label>
                    <label class="{{ isset($socials['kwork']) ? 'fill' : '' }}">
                        <img src="/storage/general/links/kwork.png" alt="kwork.com">
                        <input class="uk-input" name="socials" id="kwork" placeholder="kwork.com" value="{{ $socials['kwork'] ?? '' }}">
                    </label>
                </div>
                
            </div>
        
            <input class="uk-button {{ $theme == 'dark' ? 'uk-button-default': 'uk-button-secondary' }}" type="submit" id="js_workers_edit_submit" value="Обновить">
        </form>
    </div>
</div>