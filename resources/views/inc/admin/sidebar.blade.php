@php
    use App\Http\Controllers\Admin\ExampleWorkController;
    use App\Http\Controllers\Admin\FeedbackController;

    $work_notitice = ExampleWorkController::notViewedAdmin();
    $feedback_notitice = FeedbackController::notViewedAdmin();

    $config = [
        'Menu' => [
            'name' =>   __('Меню'),
            'img' =>    '<i class="nav-icon fas fa-link"></i>',
            'link' => 'admin.menu.index',
            'items' => []
        ],
        'Example_work' =>[
            'name' =>   __('Примеры работ'),
            'img' =>    '<i class="nav-icon fas fa-solid fa-briefcase"></i>',
            'link' => 'admin.works.index',
            'notites'   => $work_notitice,
            'items' => [
                'recycle' =>[
                    'name' => __('Корзина'),
                    'img' => '<i class="nav-icon fas fa-solid fa-recycle"></i>',
                    'link' => 'admin.works.recycle'
                ]
            ]
        ],
        // 'Users' =>[ todo
        //     'name' =>   'Users',
        //     'img' =>    '<i class="nav-icon fas fa-solid fa-person-rays"></i>',
        //     'link' => 'admin.users.index'
        // ],
        'Workers' =>[
            'name' =>   __('Профили'),
            'img' =>    '<i class="nav-icon fas fa-solid fa-person-rays"></i>',
            'link' => 'admin.workers.index'
        ],
        'Feedback' =>[
            'name' =>   __('Обратная связь'),
            'img' =>    '<i class="nav-icon fas fa-solid fa-comment"></i>',
            'link' => 'admin.feedback.index',
            'notites'   => $feedback_notitice
        ],
    ];
@endphp

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        @foreach($config as $menuItem)
            <li class="nav-item">
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

        </li>
    </ul>
</nav>