@php
    $listMenuModifier = [];

    foreach($G_menuNav as $item){
        $listMenuModifier[] = [
            'name' => $item->name,
            'link' => $item->link,
            'role' => $item->role,
            'active' => $item->active,
            'sort' => $item->sort,
        ];
    }

    usort($listMenuModifier, function($a, $b)
    {
        if($a['sort']==$b['sort']) return 0;
        return $a['sort'] < $b['sort']?1:-1;
    });
    
    $user = auth()->user();
    $role = $user != null ? $user->role : 'guest';
@endphp


@foreach($listMenuModifier as $item)
    @php
        $viewLink = false;

        if($role == 'guest' && $role == $item['role']){
            $viewLink = true;
        } elseif ($role == 'admin' || $item['role'] == $role || $item['role'] == 'guest'){
            $viewLink = true;
        }

        if ($viewLink){
            @endphp
                <x-main-menu-li route="{{ $item['link'] }}">
                    {{ trans('menu.'.$item['name']) }}
                </x-main-menu-li>
            @php
        }            
    @endphp

@endforeach