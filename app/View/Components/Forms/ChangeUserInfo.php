<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChangeUserInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $route = route('profile.change_user_info');

        $formData = [
            'email' => auth()->user()->email,
            'fio' => auth()->user()->fio
        ];

        return view('components.forms.change-user-info', compact('route', 'formData'));
    }
}
