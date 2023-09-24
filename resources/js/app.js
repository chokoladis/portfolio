import './bootstrap';

import jQuery, { error } from 'jquery';
window.$ = jQuery;

// make full script file special for admin
function updWorksAdmin(){
    $.ajax({
        url: location.href,
        method: 'GET',
        // dataType: 'JSON',
        success: function(html){
            let works = $(html).find('section.content .works_list > *');
            let paginastion  = $(html).find('section.content .paginastion > *');
            $('section.content .works_list').html(works);
            $('section.content .paginastion').html(paginastion);
        }
    });
};

function updMenuAdmin(){
    $.ajax({
        url: location.href,
        method: 'GET',
        // dataType: 'JSON',
        success: function(html){
            let works = $(html).find('section.content .links_list > *');
            // let paginastion  = $(html).find('section.content .paginastion > *');
            $('section.content .links_list').html(works);
            // $('section.content .paginastion').html(paginastion);
        }
    });
};

function updWorks(){
    $.ajax({
        url: location.href,
        method: 'GET',
        // dataType: 'JSON',
        success: function(html){
            let works = $(html).find('main .works_list > *');
            let paginastion  = $(html).find('main .paginastion > *');
            $('main .works_list').html(works);
            $('main .paginastion').html(paginastion);
        }
    });
};


$(function(){

    $('.theme-toggle').on('click', function(){
        $(this).toggleClass('active');
        $(':root').toggleClass('dark');
    })
    $(document).on('click','form [type="submit"]', function(e){

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

            var itemId = form.find('[name="id"]');

            if (formId == 'work_create'){
                
                var file_data = $('input[name="url_files"]')[0].files;

                for (var i = 0; i < file_data.length; i++) {
                    sendData.append("url_files[]", file_data[i]);
                }

            } else if (formId == 'work_edit') {
                action = '/works/'+itemId.val()+'/update/';
            } else if (formId == 'menu_edit'){
                action = '/admin/menu/'+itemId.val()+'/update/';
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
                    
                    
                    if (json.success){
                        $('#md-response .messsage').text(json.response.result);

                        if (location.href == '/admin/menu'){
                            updMenuAdmin();
                        } else if (location.href == '/admin/works') {
                            updWorksAdmin();
                        } else{
                            updWorks();
                        }
                        
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
            
        }
    });

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

    $(document).on('click','.js_menu_del', function(){

        let parent = $(this).parents('.link');
        let menuId = parent.attr('data-id');

        $.ajax({
            url: '/admin/menu/'+menuId+'/delete/',
            method: 'GET',
            dataType: 'json',
            success: function(data){

                if (data.success){
                    
                    $('.links_list [data-id="'+menuId+'"]').remove();
                    
                    updMenuAdmin();

                } else {
                    $('#response').show();
                    $('#response .messsage').html(data.error+"<br/>");
                }
            }
        });

    });

    $(document).on('click','.js_menu_edit', function(){

        let parent = $(this).parents('.link');
        let menuId = parent.attr('data-id');

        $.ajax({
            url: '/admin/menu/'+menuId+'/edit/',
            method: 'GET',
            dataType: 'json',
            success: function(data){

                if (data){
                    let form = $('#md-menu_edit');
                    form.find('[name="id"]').val(menuId);
                    form.find('[name="name"]').val(data.name);
                    form.find('[name="link"]').val(data.link);
                    form.find('[name="role"] option:contains("'+data.role+'")').prop('selected', true);
                    
                    form.find('[name="active"][value="'+data.active+'"]').prop('checked', true);

                    form.find('[name="sort"]').val(data.sort);
                    
                    UIkit.modal('#md-menu_edit').show();
                } else {
                    $('#response').show();
                    $('#response .messsage').html('Ошибка в запросе при получении данных <br/>');
                }

            }
        });

    });
    
    $(document).on('click','.header-filter .btn', function(){

        let ul = $(this).parents('ul');
        let li = $(this).parents('li');
        li.toggleClass('active');

        if (ul.find('li.active').length > 0){
            ul.addClass('active');
        } else {
            ul.removeClass('active');
        }        
        
    });

    // $('.work').on('mouseover', function(){
    //     setTimeout(() => {$(this).addClass('hovered') }, 1000);
    // });

    // $('.work').on('mouseout', function(){
    //     setTimeout(() => {$(this).removeClass('hovered')}, 1000);
    // });

    

});