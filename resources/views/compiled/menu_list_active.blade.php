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
    $role = 'guest';
    if ($user != null){
        $role = $user->role;
    }
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
                    <li class='animated'><a href="{{ $item['link'] }}">{{ $item['name'] }}</a></li>
                @php
            }            
        @endphp

    @endforeach

    
    <!-- <li class="animated"><a href="/admin/">Admin</a></li> -->
    
    