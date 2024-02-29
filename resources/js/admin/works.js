import {Helper} from './helpers';

$(function(){

    $(document).on('click','.js_admin_work_del', function(){

        let tr = $(this).parents('tr');
        let title = tr.find('.js_title_work');
        let titleFormated = Helper.escapeHtml(title.text().trim());

        let accept_del = confirm('Вы действительно хотите удалить запись с заголовком - '+titleFormated);

        if (!accept_del) return false;

        let route = $(this).attr('data-route');

        $.ajax({
            url: route,
            method: 'GET',
            dataType: 'json',
            success: function(data){

                console.log(data);
                console.log(tr);
                if (data.success){

                    tr.remove();

                } else {
                    $('#response').show();
                    $('#response .messsage').html(data.error+"<br/>");
                }
            }
        });

    });

    $('#js_work_edit_submit').on('click', function(e){

        e.preventDefault();
        
        let form = $(this).parents('form');
        let formData = form.serializeArray();
        let sendData = new FormData();

        $.each(formData, function (key, input) {
            sendData.append(input.name, input.value);
        });

        workUpdate(form, sendData);            
    });

    async function workUpdate(form, body){

        let itemId = form.find('[name="id"]');
        let action = '/works/'+itemId.val()+'/update/';

        const update = await fetch(action, 
                {
                    method: 'POST',
                    body: body,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                }
            );

        let updateJson = await update.json();

        if (updateJson.success){
            
            $('#md-response .messsage').text(updateJson.result);
            UIkit.modal('#md-response').show();

            Helper.updateWorksHtmlToAdmin();
            
        } else {
            UIkit.notification({
                message: updateJson.error,
                status: 'danger',
                timeout: 5000
            });
        }
    }

    $('form#work-filter').on('submit', function(e){
        e.preventDefault();

        var action = $(this).attr('action');
        var formData = $(this).serializeArray();
        
        let url = new URL(action);
        for (let key in formData){
            let name = formData[key]['name'];
            let val = formData[key]['value'];

            if (val){
                url.searchParams.set(name, val);
            }
        }

        location.href = url;
    });

});