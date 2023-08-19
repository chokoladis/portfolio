import './bootstrap';

import jQuery, { error } from 'jquery';
window.$ = jQuery;

$(function(){

    $('form [type="submit"]').on('click', function(e){

        // console.log('submit');
        let form = $(this).parent('form');
        let ajax = form.find('input[name="AJAX"]');
        let formId = form.attr('id');
        
        if (ajax.length && ajax.val() == 'Y' ){
            
            e.preventDefault();
            
            var action = form.attr('action');
            var method = form.attr('method');
            var formData = form.serializeArray();
            var sendData = new FormData();
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };

            $.each(formData, function (key, input) {
                sendData.append(input.name, input.value);
            });

            if (formId == 'work_create'){
                
                var file_data = $('input[name="url_files"]')[0].files;

                for (var i = 0; i < file_data.length; i++) {
                    sendData.append("url_files[]", file_data[i]);
                }

            } else if (formId == 'work_edit') {
                var work_id = form.find('[name="id"]');
                action = '/works/'+work_id.val()+'/update/';
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
                    // обновить список работ
                    
                    if (json.success){
                        // активировать кнопку
                        $('#md-response .messsage').text(json.response.result);
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
                            $('#response').show().append(value+"<br/>"); //this is my div with messages
                            }
                        });
                    }
                }
            })
            
        }
    });

    $('.js_work_del').on('click', function(){

        let parent = $(this).parents('.work');
        let workId = parent.attr('data-id');

        $.ajax({
            url: '/works/'+workId+'/delete/',
            method: 'GET',
            dataType: 'json',
            success: function(data){

                if (data.success){
                    
                    $('.works_list [data-id="'+workId+'"]').remove();

                    // $.ajax({
                    //     url: '/works?ajax=worksList',
                    //     method: 'GET',
                    //     success: function(data){
                    //         if (data){
                    //             $('.works_list .work').remove();
                    //         }
                    //     }
                    // });  

                } else {
                    // notification
                }
            }
        });

    });

    $('.js_work_edit').on('click', function(){

        // console.log('click edit');
        let parent = $(this).parents('.work');
        let workId = parent.attr('data-id');

        $.ajax({
            url: '/works/'+workId+'/edit/',
            method: 'GET',
            dataType: 'json',
            success: function(data){

                if (data){
                    // set id in new form
                    let form = $('#md-work_edit');
                    form.find('[name="id"]').val(workId);
                    form.find('[name="title"]').val(data.title);
                    form.find('[name="description"]').val(data.description);
                    // form.find('input[name="url_files"]').val(data.url_files);
                    form.find('[name="url_work"]').val(data.url_work);
                    
                    UIkit.modal('#md-work_edit').show();
                } else {
                    console.error('Ошибка в запросе при получении данных о примере работ');
                }

            }
        });

    });
    
    // 

    // $('.work').on('mouseover', function(){
    //     setTimeout(() => {$(this).addClass('hovered') }, 1000);
    // });

    // $('.work').on('mouseout', function(){
    //     setTimeout(() => {$(this).removeClass('hovered')}, 1000);
    // });

    

});