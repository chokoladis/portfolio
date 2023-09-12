@php
    $listMenuModifier = [];

    foreach($listMenu as $item){
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

<div class="list_link">
    @foreach($listMenuModifier as $item)
        @php
            $active = ($item['active'] == 1)?'active':'';
            $imgRole = ($item['role'] == 'admin')?'fa-users-cog':'fa-users';
        @endphp

        <div class="link {{ $active }}">
            <div class="sort">
                <h4>{{ $item['sort'] }}</h4>
            </div>
            <div class="content">
                <div class="title">
                    <i class="fas {{ $imgRole }}"></i>
                    <h4>{{ $item['name'] }}</h4>
                </div>                        
                <span>{{ $item['link'] }}</span>
            </div>
            <div class="area_actions">
                <div class="custom-btn clr-danger js_menu_del">
                    <span uk-icon="icon:trash" title="Удалить"></span>
                </div>
                <div class="custom-btn clr-primary js_menu_edit">
                    <span uk-icon="icon:pencil" title="Редактировать"></span>
                </div>
            </div>
        </div>                
    @endforeach
</div>