$('.file_change').on('click', function(){
    $('input[name="url_avatar"]').click();
});

$('input[name="url_avatar"]').on('change', function(){
    let user_avatar_file = $(this)[0].files;
    let form = $(this).parents('form');
    let sendData = new FormData();

    sendData.append("url_avatar", user_avatar_file[0]);
    
    profileUpdateAvatar(form, sendData)
});

async function profileUpdateAvatar(form, body){
    const change = await fetch(form.attr('action'), 
            {
                method: form.attr('method'),
                body: body,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            }
        );
    let changeRes = await change.json();
    if (changeRes.success){
        $.ajax({
            url: location.href,
            success: function(data){
                // console.log(data);
                let img = $(data).find('.form_change_img img');
                let newSrc = img.attr('src');
                $('.form_change_img img').attr('src', newSrc);
            }
        })
    }
}

$('a.js_profile_delete').on('click', function(){
    if (confirm('Вы уверенны что хотите удалить профиль?')){
        profileDelete();
    }
});

async function profileDelete(){
    const resDelete = await fetch('/profile/delete', 
            {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            }
        );

    let jsonDelete = await resDelete.json();
    if (jsonDelete.success){
        location.href="/workers";
    } else {
        UIkit.notification({
            message: jsonDelete.error,
            status: 'danger',
            timeout: 5000
        });
    }
}


$('form#worker_edit').on('submit', function(e){

    e.preventDefault();

    var formData = $(this).serializeArray();
    var sendData = new FormData();
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    $.each(formData, function (key, input) {
        if (input.name != 'socials' && input.value != ''){
            sendData.set(input.name, input.value);
        }
    });

    var socials = $(this).find('.socials input');

    for (var i = 0; i < socials.length; i++) {
        let id = $(socials[i]).attr('id');
        let val = $(socials[i]).val();
        if (val){
            sendData.append("socials["+id+"]",  val);
        }
    }
    
    profileUpdate($(this), sendData);
});

async function profileUpdate(form, body){
    const update = await fetch(form.attr('action'), 
            {
                method: 'POST',
                body: body,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            }
        );

    let updateJson = await update.json();
    if (updateJson.success){
        location.href="/profile";
    } else {
        UIkit.notification({
            message: updateJson.error,
            status: 'danger',
            timeout: 5000
        });
    }
}