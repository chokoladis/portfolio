<?php

namespace App\View\Components\Admin\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use App\Http\Controllers\Admin\ExampleWorkController;
use App\Http\Controllers\Admin\FeedbackController;

class Main extends Component
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
        $config = $this->prepareConfig();

        return view('components.admin.sidebar.main', compact('config'));
    }

    private function prepareConfig(): mixed
    {
        return [
            'Menu' => $this->getMenu(),
            'Example_work' => $this->getWorks(),
            'Users' => $this->getUsers(),
            'Workers' => $this->getWorkers(),
            'Feedback' => $this->getFeedback(),
            'Category' => $this->getCategory(),
        ];
    }

    public function getMenu(): array
    {
        return [
            'name' =>   __('Меню'),
            'img' =>    '<i class="nav-icon fas fa-link"></i>',
            'link' => 'admin.menu.index',
            'items' => []
        ];
    }

    public function getWorks(): array
    {
        $work_notitice = ExampleWorkController::notViewedAdmin();

        return [
            'name' =>   __('Примеры работ'),
            'img' =>    '<i class="nav-icon fas fa-solid fa-briefcase"></i>',
            'link' => 'admin.works.index',
            'notites'   => $work_notitice,
            'open' => Route::is('admin.works.*'),
            'items' => [
                'list' => [
                    'name' =>   __('Список'),
                    'img' =>    '<i class="nav-icon fas fa-solid fa-list-ul"></i>',
                    'link' => 'admin.works.index',
                    'notites'   => $work_notitice,
                ],
                'recycle' =>[
                    'name' => __('Корзина'),
                    'img' => '<i class="nav-icon fas fa-solid fa-recycle"></i>',
                    'link' => 'admin.works.recycle'
                ],
            ]
        ];
    }

    public function getUsers(): array
    {
        return [
            'name' => __('Пользователи'),
            'img' =>    '<i class="nav-icon fas fa-solid fa-person-rays"></i>',
            'link' => 'admin.users.index'
        ];
    }

    public function getWorkers(): array
    {
        return [
            'name' =>   __('Профили'),
            'img' =>    '<i class="nav-icon fas fa-solid fa-person-rays"></i>',
            'link' => 'admin.workers.index'
        ];
    }

    public function getFeedback(): array
    {
        $feedback_notitice = FeedbackController::notViewedAdmin();

        return [
            'name' =>   __('Обратная связь'),
            'img' =>    '<i class="nav-icon fas fa-solid fa-comment"></i>',
            'link' => 'admin.feedback.index',
            'notites'   => $feedback_notitice,
            'open' => Route::is('admin.feedback.*'),
            'items' => [
                'list' => [
                    'name' =>   __('Список'),
                    'img' =>    '<i class="nav-icon fas fa-solid fa-list-ul"></i>',
                    'link' => 'admin.feedback.index',
                    'notites'   => $feedback_notitice,
                ],
                'recycle' =>[
                    'name' => __('Корзина'),
                    'img' => '<i class="nav-icon fas fa-solid fa-recycle"></i>',
                    'link' => 'admin.feedback.recycle'
                ],
            ]
        ];
    }

    public function getCategory(): array
    {
        return [
            'name' => __('Категории'),
            'img' =>    '<i class="nav-icon fas fa-solid fa-table-list"></i>',
            'link' => 'admin.categories.index',
            'open' => Route::is('admin.category.*'),
            'items' => [
                'list' => [
                    'name' =>   __('Список'),
                    'img' =>    '<i class="nav-icon fas fa-solid fa-list-ul"></i>',
                    'link' => 'admin.categories.index',
                ],
                'add' =>[
                    'name' => __('Добавить'),
                    'img' => '<i class="nav-icon fas fa-solid fa-square-plus"></i>',
                    'link' => 'admin.categories.create'
                ],
            ]
        ];
    }
}
