<?php

return [
    'Example_work' => [
        'title' => 'Работы',
        'fields' =>[
            'title' => 'Заголовок',
            'description' => 'Описание', 
            'url_files' => 'Ссылки на картинки',
            'url_work' => 'Ссылка на результат',
        ],
        'fields_admin' => [
            'id_code' => 'ID | алиас',
            'user' => 'Пользователь',
            'title' => 'Заголовок',
            'description' => 'Описание', 
            'url_work' => 'Ссылка на результат',
            'created_at' => 'Время создания',
        ]
    ],
    'Workers' => [
        'title' => 'Профили',
        'fields' =>[
            'code' => 'Символьный код',
            'about' => 'О себе',
            'phone' => 'Телефон', 
            'url_work' => 'Ссылка на результат',
            'url_avatar' => 'Ссылка на аватарку',
            'socials' => 'Ссылки в интернете'
        ]
    ],
    'MenuNav' => [
        'title' => 'Главное меню',
        'fields' =>[
            'name' => 'Наименование',
            'link' => 'Ссылка', 
            'role' => 'Роль',
            'active' => 'Активность',
            'sort' => 'Сортировка'
        ]
    ],
    'Feedback' => [
        'title' => 'Обратная связь',
        'fields' =>[
            'ip_address' => 'IP Адрес',
            'fio' => 'ФИО', 
            'email' => 'Почта',
            'phone' => 'Телефон',
            'comment' => 'Комментарий'
        ]
    ]
];