import {Helper} from './helpers';

$(function(){

    $(document).on('click','.js_work_del', function(){

        let parent = $(this).parents('.work');
        let workId = parent.attr('data-id');

        $.ajax({
            url: '/works/'+workId+'/delete/',
            method: 'GET',
            dataType: 'json',
            success: function(data){

                if (data.success){
                    
                    $('.works_list [data-id="'+workId+'"]').remove();
                    
                    Helper.updWorksAdmin();

                } else {
                    $('#response').show();
                    $('#response .messsage').html(data.error+"<br/>");
                }
            }
        });

    });

    $(document).on('click','.js_work_edit', function(){

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
                    $('#response').show();
                    $('#response .messsage').html('Ошибка в запросе при получении данных <br/>');
                }

            }
        });

    });

    $('form#work-filter').on('submit', function(e){
        e.preventDefault();

        var action = $(this).attr('action');
        // var method = $(this).attr('method');
        var formData = $(this).serializeArray();
        // var headers = {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // };

        let url = new URL(action);
        for (let key in formData){
            let name = formData[key]['name'];
            let val = formData[key]['value'];

            if (val){
                url.searchParams.set(name, val);
            }
        }

        location.href = url;

        // $.ajax({
        //     url: url,
        //     method: method,
        //     data: formData,
        //     processData: false,
        //     contentType: false,
        //     headers: headers,
        //     dataType: 'html',
        //     success: function(html){
                
                
        //         if (html){
        //             // $('#md-response .messsage').text(json.response.result);

        //             updWorks(html);
                    
        //         } else {
        //             // $('#md-response .messsage').text(json.response.error);
        //         }

        //         // UIkit.modal('#md-response').show();
        //     },
        //     error :function( data ) {
        //         if( data.status === 422 ) {
        //             var errors = $.parseJSON(data.responseText);
        //             $.each(errors, function (key, value) {
        //                 console.log(key+ " " +value);

        //                 $('#response').addClass("alert alert-danger");
        
        //                 if($.isPlainObject(value)) {
        //                     $.each(value, function (key, value) {                       
        //                         // console.log(key+ " " +value);
        //                         $('#response').show().append(value+"<br/>");
        
        //                     });
        //                 }else{
        //                     $('#response').show();
        //                     $('#response .messsage').html(data.error+"<br/>");
        //                 }
        //             });
        //         }
        //     }
        // })

    });

});