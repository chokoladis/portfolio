@php
    $listMenuModifier = [];

    foreach($listMenu as $item){
        $listMenuModifier[] = [
            'id' => $item->id,
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

<div class="links_list">
    @foreach($listMenuModifier as $item)
        @php
            $active = ($item['active'] == 1)?'active':'';

            switch($item['role']){
                case 'admin':
                    $imgRole = 'fa-users-cog';
                    break;
                case 'user':
                    $imgRole = 'fa-users';
                    break;
                default:
                    $imgRole = 'fa-user-clock';
                    break;
            }

            //fa-person-circle-question
        @endphp

        <div class="link {{ $active }}" data-id="{{ $item['id'] }}">
            <div class="sort">
                <h4>{{ $item['sort'] }}</h4>
            </div>
            <div class="content">
                <div class="title">
                    <i class="fas {{ $imgRole }}"></i>
                    <h4>{{ trans('menu.'.$item['name']) }}</h4>
                </div>                        
                <span>{{ $item['link'] }}</span>
            </div>
            <div class="area_actions">
                <div class="custom-btn clr-primary">
                    <a href="{{ route('admin.menu.edit', $item['id'] ) }}">
                        <span uk-icon="icon:pencil" title="Редактировать"></span>
                    </a>
                </div>
                <div class="custom-btn clr-danger js_menu_del">
                    <span uk-icon="icon:trash" title="Удалить"></span>
                </div>
            </div>
        </div>                
    @endforeach
</div>