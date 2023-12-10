// todo change user-image

$('.file_change').on('click', function(){
    $('input[name="url_avatar"]').click();
});

$('input[name="url_avatar"]').on('change', function(){
    let user_avatar_file = $(this)[0].files;
    let form = $(this).parents('form');
    let sendData = new FormData();

    sendData.append("url_avatar", user_avatar_file[0]);
    
    changeUserAvatarAjax(form, sendData)
});

async function changeUserAvatarAjax(form, body){
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
                let img = $(data).find('.form_change_img img');
                let newSrc = img.attr('src');
                $('.form_change_img img').attr('src', newSrc);
            }
        })
    }
}