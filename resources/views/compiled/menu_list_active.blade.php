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
    
@endphp


    @foreach($listMenuModifier as $item)
        @php
            $user = auth()->user();
            $role = 'User';
            if ($user != null){
                $role = $user->role;
            }
            

            if ($role == 'admin'){
                @endphp
                    <li class='animated'><a href="{{ $item['link'] }}">{{ $item['name'] }}</a></li>
                @php
            } elseif ($item['role'] == $role){
                
                @endphp
                    <li class='animated'><a href="{{ $item['link'] }}">{{ $item['name'] }}</a></li>
                @php
            } 
        @endphp
        <!-- dump($role); -->

    @endforeach

    
    <!-- <li class="animated"><a href="/admin/">Admin</a></li> -->
    
    