
@php
    $theme = request()->cookie('theme');
@endphp
<div id="md-feedback-add" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <div class="custom-close-icon uk-modal-close">X</div>
        <form action="{{ route('feedback.store') }}" method="POST" id="feedback">
            <h2 class="uk-modal-title">{{ __('Оставьте обратную связь') }}</h2>

            <div class="uk-margin">
                <input class="uk-input" type="text" name="fio" require="true" autocomplete="on" placeholder="{{ __('ФИО') }}">
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="email" name="email" require="true" autocomplete="email" placeholder="{{ __('Почта') }}">
            </div>
            <div class="uk-margin">
                <input class="uk-input js-phone-mask" name="phone" require="true" autocomplete="tel" placeholder="{{ __('Телефон') }}">
            </div>
            <div class="uk-margin">
                <textarea class="uk-textarea" name="comment" autocomplete="on" placeholder="{{ __('Комментарий') }}"></textarea>
            </div>
        
            <input class="uk-button uk-button-default" type="submit" id="js-feedback-submit" value="{{ __('Отправить') }}">
        </form>
    </div>
</div>