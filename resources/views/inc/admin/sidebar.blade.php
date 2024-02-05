@php
    $config = [
        'Menu' => [
            'name' =>   'Menu',
            'img' =>    '<i class="nav-icon fas fa-link"></i>',
            'link' => 'admin.menu.index',
            'items' => []
        ],
        'Example_work' =>[
            'name' =>   'Examples work',
            'img' =>    '<i class="nav-icon fas fa-solid fa-briefcase"></i>',
            'link' => 'admin.works.index'
        ],
        'Workers' =>[
            'name' =>   'Workers',
            'img' =>    '<i class="nav-icon fas fa-solid fa-person-rays"></i>',
            'link' => 'admin.workers.index'
        ],
    ];
@endphp

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        @foreach($config as $menuItem)
            <li class="nav-item">
                <a href="<?=route($menuItem['link'])?>" class="nav-link">
                    <?=$menuItem['img']?>
                    <p>{{ $menuItem['name'] }}</p>
                </a>
                @if(!empty($menuItem['items']))

                    <ul class="nav nav-treeview">

                        @foreach($menuItem['items'] as $subitem)
                            <li class="nav-item">
                                <a href="{{ $subitem['link'] }}" class="nav-link">
                                    {{ $subitem['img'] }}
                                    <p>{{ $subitem['name'] }}</p>
                                </a>
                            </li>
                        @endforeach

                    </ul>

                @endif
            </li>
        @endforeach

        </li>
    </ul>
</nav>