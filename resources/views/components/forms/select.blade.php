@props(['title', 'field', 'values'])

<div class="uk-margin">
    <p>{{ __($title) }}</p>
    <select name="{{ $field }}" class="uk-select">
        @php
            $selected = old($field);

            echo '<option '.($selected ? '' : 'selected').'></option>';

            foreach($values as $value) {

                $checkSelect = $selected === $value ? 'selected' : '';

                if (is_object($value)){
                    @endphp
                    <option value="<?= $value->id ?>" <?= $checkSelect ?>><?= $value->name ?></option>
                    @php
                } else {
                    @endphp
                        <option <?= $checkSelect ?>><?= $value ?> </option>
                    @php
                }
            }
        @endphp
    </select>
    @if($errors->has($field))
        <div class="error">{{ $errors->first($field) }}</div>
    @endif

</div>
