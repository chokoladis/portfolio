<?php

namespace App\View\Components\Menu;

use App\Models\MenuNav;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Main extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(array $menuList = [])
    {
        $this->data = !empty($menuList) ? $menuList : MenuNav::getActive();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $arMenu = $this->prepare();

        return view('components.menu.main', compact('arMenu'));
    }

    public function prepare(): array
    {
        foreach($this->data as $item){

            $role = getUserRole();

            // todo check in gates or policy
            if($role == 'guest' && $role == $item['role']){
            } elseif ($role == 'admin' || $item['role'] == $role || $item['role'] == 'guest'){
            } else {
                continue;
            }

            $arMenu[] = [
                'name' => $item->name,
                'link' => $item->link,
                'role' => $item->role,
                'active' => $item->active,
                'sort' => $item->sort,
            ];
        }

        usort($arMenu, function($a, $b)
        {
            if($a['sort']==$b['sort']) return 0;
            return $a['sort'] < $b['sort']?1:-1;
        });

        return $arMenu;
    }
}
