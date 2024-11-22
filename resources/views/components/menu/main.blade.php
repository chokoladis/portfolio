@foreach($arMenu as $item)
    <x-menu.main-li route="{{ $item['link'] }}">
        {{ trans('menu.'.$item['name']) }}
    </x-menu.main-li>
@endforeach
