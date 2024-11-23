@props(['title', 'field', 'values'])

<div class="uk-margin">
    <p>{{ __($title) }}</p>
    <select name="{{ $field }}" class="uk-select">
        @php
            $selected = old($field);

            foreach($values as $value) {
                $checkSelect = $selected === $value ? 'selected' : '';
                echo '<option '.$checkSelect.'>'.$value.'</option>';
            }
        @endphp
    </select>
    @if($errors->has($field))
        <div class="error">{{ $errors->first($field) }}</div>
    @endif

</div>
