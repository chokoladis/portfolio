@foreach ($columns as $name => $arColumn)
    @if ($name !== 'id')
        @switch($arColumn['type'])
            @case('boolean')

                <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                    <label for="{{ $name }}">
                        <input type="checkbox" name="{{ $name }}" class="uk-checkbox" {{ old($name) ?  old($name) : 'checked' }}>{{ $arColumn['name_ru'] }}
                    </label>
                    @if($errors->has($name))
                        <div class="error">{{ $errors->first($name) }}</div>
                    @endif
                </div>

                @break
            @case('datetime')
            
                <div class="uk-margin">
                    <input type="date" name="{{ $name }}" placeholder="{{ $arColumn['name_ru'] }}" value="{{ old($name) }}">

                    @if($errors->has($name))
                        <div class="error">{{ $errors->first($name) }}</div>
                    @endif
                </div>

                @break
            @default

                <div class="uk-margin">
                    <input type="text" name="{{ $name }}" placeholder="{{ $arColumn['name_ru'] }}"
                        class="uk-input" aria-label="Input" value="{{ old($name) }}">

                    @if($errors->has($name))
                        <div class="error">{{ $errors->first($name) }}</div>
                    @endif
                </div>
        @endswitch
    @endif
@endforeach