<main>
    <div class="container">
        <h2>Была заполнена форма отклика</h2>

        <hr>

        ФИО: {{ $feedback->fio }} <br>
        Email: {{ $feedback->email }}<br>
        Телефон: {{ $feedback->phone }}<br>
        Комментарий: {{ $feedback->comment }}<br>

    </div>
</main>