import { Helper } from './variables';

async function sendAcceptEmail() {

    const query = await fetch('/profile/verify/resend',
        {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        }
    );

    console.log(query);

    if (query.ok && query.redirected) {

        $('#md-response .message').text("Письмо для верификации почты отправлена");
        UIkit.modal('#md-response').show();

    } else {
        UIkit.notification({
            message: query.statusText,
            status: 'danger',
            timeout: 5000
        });

        throw new Error(`Response status: ${query.status}`);
    }
}

async function workerAdd(form, body) {

    let action = form.attr('action');

    const add = await fetch(action,
        {
            method: 'POST',
            body: body,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        }
    );

    let addJson = await add.json();

    if (addJson.success) {

        $('#md-response .message').text(addJson.result);
        UIkit.modal('#md-response').show();

        Helper.updWorkersHtml();

        $('button.js-add-worker').remove();

    } else {
        UIkit.notification({
            message: addJson.error,
            status: 'danger',
            timeout: 5000
        });
    }
}

async function profileUpdateAvatar(form, body) {
    const change = await fetch(form.attr('action'),
        {
            method: form.attr('method'),
            body: body,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        }
    );
    let changeRes = await change.json();
    if (changeRes.success) {
        $.ajax({
            url: location.href,
            success: function (data) {
                // console.log(data);
                let img = $(data).find('.form_change_img img');
                let newSrc = img.attr('src');
                $('.form_change_img img').attr('src', newSrc);
            }
        })
    }
}

async function profileUpdate(form, body) {
    const update = await fetch(form.attr('action'),
        {
            method: 'POST',
            body: body,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        }
    );

    let updateJson = await update.json();
    if (updateJson.success) {
        location.href = "/profile";
    } else {
        UIkit.notification({
            message: updateJson.error,
            status: 'danger',
            timeout: 5000
        });
    }
}

async function profileDelete() {
    const resDelete = await fetch('/profile/delete',
        {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        }
    );

    let jsonDelete = await resDelete.json();
    if (jsonDelete.success) {
        location.href = "/workers";
    } else {
        UIkit.notification({
            message: jsonDelete.error,
            status: 'danger',
            timeout: 5000
        });
    }
}

async function workDelete(action) {
    
    const resDelete = await fetch(action,
        {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        }
    );

    let jsonDelete = await resDelete.json();
    if (jsonDelete.success) {
        location.href = "/workers";
    } else {
        UIkit.notification({
            message: jsonDelete.error,
            status: 'danger',
            timeout: 5000
        });
    }
}

$(function () {

    $('.file_change').on('click', function () {
        $('input[name="url_avatar"]').click();
    });

    $('#js_workers_add_submit').on('click', function (e) {

        e.preventDefault();

        let error = 0;
        let form = $(this).parent('form');

        var formData = form.serializeArray();
        var sendData = new FormData();

        // добавление стандартных полей
        $.each(formData, function (key, input) {
            let form_input = form.find('input[name="' + input.name + '"]');

            Helper.resetInput(form_input);
            if (form_input.length && form_input.attr('require') && input.value.length < 1) {
                Helper.showError(form_input, 'Вы не заполнили обязательное поле');
                error++;
            }
            if (input.name != 'socials' && input.value != '') {
                sendData.set(input.name, input.value);
            }
        });

        var file_data = form.find('[name="photo"]')[0].files;
        if (file_data.length > 0) {
            sendData.append("photo", file_data[0]);
        }

        var socials = $('.socials input');

        for (var i = 0; i < socials.length; i++) {
            let id = $(socials[i]).attr('id');
            let val = $(socials[i]).val();
            if (val) {
                sendData.append("socials[" + id + "]", val);
            }
        }

        if (error)
            return;

        workerAdd(form, sendData);
    });

    $('input[name="url_avatar"]').on('change', function () {
        let user_avatar_file = $(this)[0].files;
        let form = $(this).parents('form');
        let sendData = new FormData();

        sendData.append("url_avatar", user_avatar_file[0]);

        profileUpdateAvatar(form, sendData)
    });

    $(document).on('click', '#js_send_accept_email', () => {
        sendAcceptEmail();
    });

    $('#md-worker_add .photo input').on('change', function () {

        let file = this.files[0];
        let p = $(this).siblings('p');

        if (file) {
            p.removeClass('uk-hidden');
            p.text('Текущее изображение : ' + file.name);
        } else {
            p.addClass('uk-hidden');
        }

    });


    $('form#worker_edit').on('submit', function (e) {

        e.preventDefault();

        var formData = $(this).serializeArray();
        var sendData = new FormData();
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };

        $.each(formData, function (key, input) {
            if (input.name != 'socials' && input.value != '') {
                sendData.set(input.name, input.value);
            }
        });

        var socials = $(this).find('.socials input');

        for (var i = 0; i < socials.length; i++) {
            let id = $(socials[i]).attr('id');
            let val = $(socials[i]).val();
            if (val) {
                sendData.append("socials[" + id + "]", val);
            }
        }

        profileUpdate($(this), sendData);
    });

    $('a.js_profile_delete').on('click', function () {
        if (confirm('Вы уверенны что хотите удалить профиль?')) {
            profileDelete();
        }
    });

    $('.js-profile-work-delete').on('click', function(){

        const link = $(this).attr('data-href');

        workDelete(link);
    });
});