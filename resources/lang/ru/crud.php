<?php

return [
    'Example_work' => [
        'title' => 'Работы',
        'attributes' => [
            'id' => 'ID',
            'user_id' => 'Код пользователя',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'slug' => 'Алиас',
            'url_files' => 'Пути прикрепленных файлов', 
            'url_work' => 'Ссылка на работу',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
            'deleted_at' => 'Время удаления',
        ],
        'fields' =>[
            'title' => 'Заголовок',
            'description' => 'Описание', 
            'url_files' => 'Ссылки на картинки',
            'url_work' => 'Ссылка на результат',
        ],
        'fields_list_admin' => [
            'id_code' => 'ID | алиас',
            'user' => 'Пользователь',
            'title' => 'Заголовок',
            'description' => 'Описание', 
            'url_work' => 'Ссылка на результат',
            'created_at' => 'Время создания',
        ]
    ],
    'Users' => [
        'title' => 'Пользователи',
        'attributes' => [
            'id' => 'ID',
            'fio' => 'ФИО',
            'email' => 'Почта',
            'email_verified_at' => 'Время верификации почты',
            'role' => 'Роль', 
            'password' => 'Пароль',
            'remember_token' => 'Запоминающий токен',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
        ],
        'fields' =>[
            'fio' => 'ФИО',
            'email' => 'Почта',
            'role' => 'Роль', 
            'password' => 'Пароль'
        ],
        'fields_list_admin' => [
            'id' => 'ID',
            'fio' => 'ФИО',
            'email' => 'Почта',
            'role' => 'Роль', 
            'created_at' => 'Время создания',
        ]
    ],
    'Workers' => [
        'title' => 'Профили',
        'attributes' => [
            'id' => 'ID',
            'user_id' => 'Код пользователя',
            // 'title' => 'Заголовок',
            // 'description' => 'Описание',
            // 'slug' => 'Алиас',
            // 'url_files' => 'Пути прикрепленных файлов', 
            // 'url_work' => 'Ссылка на работу',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
            'deleted_at' => 'Время удаления',
        ],
        'fields' =>[
            'code' => 'Символьный код',
            'about' => 'О себе',
            'phone' => 'Телефон', 
            'url_avatar' => 'Ссылка на аватарку',
            'socials' => 'Ссылки в интернете'
        ],
        'fields_list_admin' => [
            'id_code' => 'ID | код',
            'url_avatar' => 'Аватарка',
            'user_name' => 'ФИО',            
            'about' => 'О себе',
            'phone' => 'Телефон', 
            'created_at' => 'Время создания',
        ]
    ],
    'MenuNav' => [
        'title' => 'Главное меню',
        'attributes' => [
            'id' => 'ID',
            // 'user_id' => 'Код пользователя',
            // 'title' => 'Заголовок',
            // 'description' => 'Описание',
            // 'slug' => 'Алиас',
            // 'url_files' => 'Пути прикрепленных файлов', 
            // 'url_work' => 'Ссылка на работу',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
            'deleted_at' => 'Время удаления',
        ],
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
        'attributes' => [
            'id' => 'ID',
            'ip_address' => 'IP Адрес',
            'fio' => 'ФИО',
            'email' => 'Почта', 
            'phone' => 'Телефон',
            'comment' => 'Комментарий',
            'created_at' => 'Время создания',
            'updated_at' => 'Время обновления',
            'deleted_at' => 'Время удаления',
        ],
        'fields' =>[
            'ip_address' => 'IP Адрес',
            'fio' => 'ФИО', 
            'email' => 'Почта',
            'phone' => 'Телефон',
            'comment' => 'Комментарий'
        ]
    ]
];