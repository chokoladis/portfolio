import {Helper} from './variables';

$(function(){

    $('#md-worker_add .photo input').on('change', function(){

        let file = this.files[0];
        let p = $(this).siblings('p');

        if (file){
            p.removeClass('uk-hidden');
            p.text('Текущее изображение : '+file.name);
        } else {
            p.addClass('uk-hidden');
        }
        
    });

    $('#js_workers_add_submit').on('click', function(e){
        
        e.preventDefault();

        let error = 0;
        let form = $(this).parent('form');
        
        var formData = form.serializeArray();
        var sendData = new FormData();

        // добавление стандартных полей
        $.each(formData, function (key, input) {
            let form_input = form.find('input[name="'+input.name+'"]');
            
            Helper.resetInput(form_input);
            if (form_input.length && form_input.attr('require') && input.value.length < 1){
                Helper.showError(form_input, 'Вы не заполнили обязательное поле');
                error++;
            }
            if (input.name != 'socials' && input.value != ''){
                sendData.set(input.name, input.value);
            }
        });

        // добавление аватарки
        var file_data = form.find('[name="photo"]')[0].files;
        if (file_data.length > 0 ){
            sendData.append("photo", file_data[0]);
        }

        // добавление соцсетей
        var socials = $('.socials input');

        for (var i = 0; i < socials.length; i++) {
            let id = $(socials[i]).attr('id');
            let val = $(socials[i]).val();
            if (val){
                sendData.append("socials["+id+"]",  val);
            }
        }

        if (error) //show errors
            return;

        workerAdd(form, sendData);
    });


    async function workerAdd(form, body){

        let action = form.attr('action');

        const add = await fetch(action, 
                {
                    method: 'POST',
                    body: body,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                }
            );

        let addJson = await add.json();

        if (addJson.success){
            
            $('#md-response .messsage').text(addJson.result);
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

});