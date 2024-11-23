<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        @foreach($config as $menuItem)
            <li class="nav-item {{ isset($menuItem['open']) && $menuItem['open'] ? 'menu-is-opening menu-open' : '' }}">

                <a href="{{ route($menuItem['link']) }}" class="nav-link">
                    {!! $menuItem['img'] !!}
                    <p>{{ $menuItem['name'] }}</p>
                    @if(isset($menuItem['notites']) && $menuItem['notites'] > 0)
                        <span class="badge badge-info right">{{ $menuItem['notites'] }}</span>
                    @endif
                </a>

                @if(!empty($menuItem['items']))

                    <ul class="nav nav-treeview">
                        @foreach($menuItem['items'] as $subitem)

                            <li class="nav-item">
                                <a href="{{ route($subitem['link']) }}" class="nav-link">
                                    {!! $subitem['img'] !!}
                                    <p>{{ $subitem['name'] }}</p>
                                </a>
                            </li>

                        @endforeach
                    </ul>

                @endif
            </li>
        @endforeach
    </ul>
</nav>
