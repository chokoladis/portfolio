
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
        
        let form = $(this).parent('form');
        // let ajax = form.find('input[name="AJAX"]');
        
        // if (ajax.length && ajax.val() == 'Y' ){
            
            e.preventDefault();
            
            // console.log();
            var action = form.attr('action');
            var method = form.attr('method');
            var formData = form.serializeArray();
            var sendData = new FormData();
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };

            $.each(formData, function (key, input) {
                if (input.name != 'socials'){
                    sendData.set(input.name, input.value);
                }
            });

            var socials = $('.socials input');

            for (var i = 0; i < socials.length; i++) {
                let id = $(socials[i]).attr('id');
                let val = $(socials[i]).val();
                if (val){
                    let obj = {name:id, value:val};
                    sendData.append("socials[]",  JSON.stringify(obj));
                }                
            }

            $.ajax({
                url: action,
                method: method,
                data: sendData,
                processData: false,
                contentType: false,
                headers: headers,
                dataType: 'JSON',
                success: function(json){
                    
                    console.log(json);
                    if (json.success){
                        $('#md-response .messsage').text(json.response.result);

                        // worksUpd()
                        
                    } else {
                        $('#md-response .messsage').text(json.response.error);
                    }

                    UIkit.modal('#md-response').show();
                },
                error :function( data ) {
                    if( data.status === 422 ) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            console.log(key+ " " +value);

                            $('#response').addClass("alert alert-danger");
            
                            if($.isPlainObject(value)) {
                                $.each(value, function (key, value) {                       
                                    // console.log(key+ " " +value);
                                    $('#response').show().append(value+"<br/>");
            
                                });
                            }else{
                                $('#response').show();
                                $('#response .messsage').html(data.error+"<br/>");
                            }
                        });
                    }
                }
            })
        // }
        
    });

});