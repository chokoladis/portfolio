@foreach($arMenu as $item)
    <x-main-menu-li route="{{ $item['link'] }}">
        {{ trans('menu.'.$item['name']) }}
    </x-main-menu-li>
@endforeach
