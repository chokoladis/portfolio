@props(['title', 'type', 'checked', 'field', 'multiple'])

<div class="uk-margin">

    @switch($type)
        @case('checkbox')
            <label>
                <input type="checkbox" name="{{ $field }}" >
                <span>{{ $title }}</span>
            </label>
            @break

        @case('textarea')
            <textarea class="uk-textarea" name="{{ $field }}" placeholder="{{ $title }}">{{ old($field) }}</textarea>
            @break

        @case('file')
            <div class="js-upload" uk-form-custom>
                <input type="file" name="{{ $field }}" @isset($multiple) multiple="multiple" @endisset>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">{{ __('Файл для ').$title }}</button>
            </div>
            @break

        @default
            <input class="uk-input" type="{{ $type }}" name="{{ $field }}" placeholder="{{ $title }}" value="{{ old($field) }}">
            @break

    @endswitch

</div>
