@props(['worker'])

<h2>{{ __('Основная информация') }}</h2>

<p>{{ __('ФИО: ').$worker['fio'] }}</p>
<p>{{ __('Телефон: ').$worker['phone'] }}</p>