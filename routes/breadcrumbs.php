<?php
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});

Breadcrumbs::for('works', function ($trail) {
    $trail->parent('home');
    $trail->push('Работы', route('work.index'));
});
Breadcrumbs::for('work', function ($trail, $work) {
    $trail->parent('works');
    $trail->push($work->title, route('work.detail', $work->slug));
});

Breadcrumbs::for('workers', function ($trail) {
    $trail->parent('home');
    $trail->push('Профили', route('workers.index'));
});
Breadcrumbs::for('worker', function ($trail, $worker) {
    $trail->parent('workers');
    $trail->push($worker['name'], route('workers.detail', $worker['code']));
});

Breadcrumbs::for('profile', function ($trail) {
    $trail->parent('home');
    $trail->push('Профиль', route('profile.index'));
});
Breadcrumbs::for('profile.works', function ($trail) {
    $trail->parent('profile');
    $trail->push('Мои работы', route('profile.works.index'));
});
Breadcrumbs::for('profile.works.edit', function ($trail, $work) {
    $trail->parent('profile.works');
    $trail->push($work->title, route('profile.works.edit'));
});
