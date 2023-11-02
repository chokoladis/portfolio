import {Helper} from './variables';

$(function(){

    $('#md-worker_new .photo input').on('change', function(){

        let file = this.files[0];
        let p = $(this).siblings('p');

        if (file){
            p.removeClass('uk-hidden');
            p.text('Текущее изображение : '+file.name);
        } else {
            p.addClass('uk-hidden');
        }
        
    });

    $('.socials input').on('focus', function(){
        let label = $(this).parents('label');
        label.addClass('focus');
    });

    $('.socials input').on('blur', function(){
        let label = $(this).parents('label');
        label.removeClass('focus');

        let inputVal = $(this).val();

        if (inputVal){
            label.addClass('fill');
        } else {
            label.removeClass('fill');
        }
    });

    $('#js_workers_add_submit').on('click', function(e){
        
        let error = 0;
        let form = $(this).parent('form');
        // let ajax = form.find('input[name="AJAX"]');
        
        // if (ajax.length && ajax.val() == 'Y' ){
            
            e.preventDefault();
            
            var action = form.attr('action');
            var method = form.attr('method');
            var formData = form.serializeArray();
            var sendData = new FormData();
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };

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

            if (error)
                return;

            $.ajax({
                url: action,
                method: method,
                data: sendData,
                processData: false,
                contentType: false,
                headers: headers,
                dataType: 'JSON',
                success: function(json){
                    
                    // console.log(json);
                    if (json.errors){
                        $('#md-response .messsage').text(json.message);
                    } else if(json.success){
                        $('#md-response .messsage').text(json.response.result);

                        // worksUpd()  
                    } 

                    UIkit.modal('#md-response').show();
                },
                error :function( data ) {
                    if( data.status === 422 ) {
                        var errors = $.parseJSON(data.responseText).errors;
                        
                        console.log(errors);
                        $.each(errors, function (key, value) {
                            let input = form.find('[name="'+key+'"]');
                            console.log(key+ " " +value);
                            console.log(input);

                            if (input.length){
                                Helper.showError(input, value);
                            }
                        });
                    }
                }
            })
        // }
        
    });

});