// todo change user-image

$('.file_change').on('click', function(){
    $('input[name="new_user_avatar"]').click();
});

$('input[name="new_user_avatar"]').on('change', function(){
    let user_avatar_file = $(this)[0].files;
    let form = $(this).parents('form');
    let sendData = new FormData();

    sendData.append("user_avatar", user_avatar_file[0]);

    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        processData: false,
        contentType: false,
        data: sendData,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(data){
            console.log(data);
        }
    });
});