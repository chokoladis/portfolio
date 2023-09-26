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
                    
                    updWorks();

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

});