<?php
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push(__('Главная'), route('home'));
});


Breadcrumbs::for('search', function ($trail, $input_val) {
    $trail->parent('home');
    $trail->push( __('Поиск - '). $input_val , route('search', ['search' => $input_val]));
});

Breadcrumbs::for('works', function ($trail) {
    $trail->parent('home');
    $trail->push( __('Работы'), route('work.index'));
});
Breadcrumbs::for('work', function ($trail, $work) {
    $trail->parent('works');
    $trail->push($work->title, route('work.detail', $work->slug));
});

Breadcrumbs::for('workers', function ($trail) {
    $trail->parent('home');
    $trail->push( __('Профили'), route('workers.index'));
});
Breadcrumbs::for('worker', function ($trail, $worker) {
    $trail->parent('workers');
    $trail->push($worker['name'], route('workers.detail', $worker['code']));
});

Breadcrumbs::for('profile', function ($trail) {
    $trail->parent('home');
    $trail->push( __('Профиль'), route('profile.index'));
});
Breadcrumbs::for('profile.works', function ($trail) {
    $trail->parent('profile');
    $trail->push( __('Мои работы'), route('profile.works.index'));
});
Breadcrumbs::for('profile.works.edit', function ($trail, $work) {
    $trail->parent('profile.works');
    $trail->push($work->title, route('profile.works.edit', $work));
});

Breadcrumbs::for('admin', function ($trail) {
    $trail->push( __('Панель'), route('admin.index'));
});
// 
Breadcrumbs::for('admin.menu', function ($trail) {
    $trail->parent('admin');
    $trail->push( __('Меню'), route('admin.menu.index'));
});
Breadcrumbs::for('admin.menu.edit', function ($trail, $menuNav) {
    $trail->parent('admin.menu');
    $trail->push( __('Пункт - ').$menuNav->name, route('admin.menu.edit', $menuNav));
});
Breadcrumbs::for('admin.menu.add', function ($trail) {
    $trail->parent('admin.menu');
    $trail->push( __('Создание'), route('admin.menu.create'));
});
// 
Breadcrumbs::for('admin.works', function ($trail) {
    $trail->parent('admin');
    $trail->push( __('Работы'), route('admin.works.index'));
});
Breadcrumbs::for('admin.works.edit', function ($trail, $work) {
    $trail->parent('admin.works');
    $trail->push($work->title, route('admin.works.edit', $work));
});
Breadcrumbs::for('admin.works.recycle', function ($trail) {
    $trail->parent('admin.works');
    $trail->push( __('Корзина'), route('admin.works.recycle'));
});
//
Breadcrumbs::for('admin.users', function ($trail) {
    $trail->parent('admin');
    $trail->push( __('Пользователи'), route('admin.users.index'));
});
Breadcrumbs::for('admin.users.edit', function ($trail, $user) {
    $trail->parent('admin.users');
    $trail->push($user->name, route('admin.users.edit', $user));
});
// 
Breadcrumbs::for('admin.workers', function ($trail) {
    $trail->parent('admin');
    $trail->push( __('Профили'), route('admin.workers.index'));
});
Breadcrumbs::for('admin.workers.edit', function ($trail, $worker) {
    $trail->parent('admin.workers');
    $trail->push($worker->user->name, route('admin.workers.edit', $worker));
});
// 
Breadcrumbs::for('admin.feedback', function ($trail) {
    $trail->parent('admin');
    $trail->push( __('Обратная связь'), route('admin.feedback.index'));
});
Breadcrumbs::for('admin.feedback.show', function ($trail, $feedback) {
    $trail->parent('admin.feedback');
    $trail->push( __('Заявка от ').$feedback->email, route('admin.feedback.show', $feedback));
});

// Breadcrumbs::for('admin.menu.add', function ($trail) {
//     $trail->parent('admin.menu');
//     $trail->push( __('Создание'), route('admin.menu.create'));
// });
// Breadcrumbs::for('profile.works.edit', function ($trail, $work) {
//     $trail->parent('profile.works');
//     $trail->push($work->title, route('profile.works.edit', $work));
// });