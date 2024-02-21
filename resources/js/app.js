import './variables';
// import './jquery.mask';
import 'jquery-mask-plugin';
import {Helper} from './variables';


// todo 
// GenerateRoutesForJavascript
$('.js-phone-mask').mask('+9 999 9999 999');

$(function(){
    $('.theme-toggle').on('click', function(){
        
        $(this).toggleClass('active');
        $(':root').toggleClass('dark');

        let f_htmlDark = $('html').hasClass('dark');
        var activeTheme = '';

        activeTheme = f_htmlDark ? 'dark' : 'light';
        
        $.ajax({
            url: '/ajax/changeTheme/',
            data: {
                'activeTheme' : activeTheme
            },
            method: 'GET',
            headers: {            
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')        
            },
            success: function(data){
                // console.log(data);
            }
        });
        
    });

    $(document).on('click','form [type="submit"]', function(e){

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

            if (formId == 'work_add'){
                
                var file_data = $('input[name="url_files"]')[0].files;

                for (var i = 0; i < file_data.length; i++) {
                    sendData.append("url_files[]", file_data[i]);
                }

            } else if (formId === 'menu_edit'){
                action = '/admin/menu/'+itemId.val()+'/update/';
            }  else if (formId === 'feedback') {
                // 
            } else {
                return;
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
                        $('#md-response .messsage').text(json.result);

                        if (location.href == '/admin/menu'){
                            Helper.updMenuAdmin();
                        } else if (location.href == '/admin/works') {
                            Helper.updateWorksHtmlToAdmin();
                        } else{
                            Helper.updateWorksHtml();
                        }
                        
                    } else {
                        $('#md-response .messsage').text(json.error);
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
});