@foreach ($columns as $name => $arColumn)
    @if ($name !== 'id')
        @php
            $value = old($name) ? old($name) : $model->$name;
        @endphp
        @switch($arColumn['type'])
            @case('boolean')

                <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                    <label for="{{ $name }}">
                        <input type="checkbox" name="{{ $name }}" class="uk-checkbox" {{ $value ?  $value : 'checked' }}>{{ $arColumn['name_ru'] }}
                    </label>
                    @if($errors->has($name))
                        <div class="error">{{ $errors->first($name) }}</div>
                    @endif
                </div>

                @break
            @case('datetime')
            
                <div class="uk-margin">
                    <p>{{ $arColumn['name_ru'] }}</p>
                    <input type="date" name="{{ $name }}" value="{{ $value }}">

                    @if($errors->has($name))
                        <div class="error">{{ $errors->first($name) }}</div>
                    @endif
                </div>

                @break

            @case('json')

                @php
                    $arCheckbox = json_decode($value,1);    
                @endphp
                
                <div class="json_object" data-json-key="{{ $name }}">

                    <h5>{{ $arColumn['name_ru'] }}</h5>

                    @foreach ($arCheckbox as $key => $jsonVal)
                        <div class="uk-margin-small">
                            <p>{{ $key }}</p>
                            <input type="text" name="{{ $key }}" value="{{ $jsonVal }}">

                            @if($errors->has($name))
                                <div class="error">{{ $errors->first($name) }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>

                @break
            @default

                <div class="uk-margin">
                    <p>{{ $arColumn['name_ru'] }}</p>
                    <input type="text" name="{{ $name }}" class="uk-input" aria-label="Input" value="{{ $value }}">

                    @if($errors->has($name))
                        <div class="error">{{ $errors->first($name) }}</div>
                    @endif
                </div>
        @endswitch
    @endif
@endforeach