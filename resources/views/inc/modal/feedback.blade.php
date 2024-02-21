
@php
    $theme = request()->cookie('theme');
@endphp
<div id="md-feedback-add" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <div class="custom-close-icon uk-modal-close">X</div>
        <form action="{{ route('feedback.store') }}" method="POST" id="feedback" enctype="multipart/form-data">
            <h2 class="uk-modal-title">{{ __('Оставьте обратную связь') }}</h2>

            @csrf

            <div class="uk-margin">
                <input class="uk-input" type="text" name="fio" require autocomplete="on" placeholder="{{ __('ФИО') }}">
            </div>
            <div class="uk-margin">
                <input class="uk-input" type="email" name="mail" require autocomplete="mail" placeholder="{{ __('Почта') }}">
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