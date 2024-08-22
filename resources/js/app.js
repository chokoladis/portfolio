import './variables';
// import './jquery.mask';
import 'jquery-mask-plugin';
import {Helper} from './variables';


// js_send_accept_email todo
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

    $('.btn-mob-menu').on('click', () => {
        $('.mob-menu').toggleClass('show');
    });

    $('.mob-menu .close').on('click', () => {
        $('.mob-menu').removeClass('show');
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
            // } else if (formId === 'worker_add'){

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

                        let message = `<h4>${json.result}</h4>`;
                        
                        if (json.error){
                            message += `<p class='uk-text-warning'>${json.error}</p>`;
                        }

                        $('#md-response .message').html(message);

                        if (location.href == '/admin/menu'){
                            Helper.updMenuAdmin();
                        } else if (location.href == '/admin/works') {
                            Helper.updateWorksHtmlToAdmin();
                        } else{
                            Helper.updateWorksHtml();
                        }
                        
                    } else {
                        $('#md-response .message').text(json.error);
                    }

                    UIkit.modal('#md-response').show();
                },
                error :function( data ) {
                    if( data.status === 422 ) {

                        var responseText = $.parseJSON(data.responseText);
                        let errors = responseText.errors;

                        if (errors){
                            $.each(errors, function (code, textError) {
                                let text = textError.join();
                                Helper.showError( form.find('[name='+code+']'), textError);
                            });
                        } else {
                            let mess = data.error ? data.error : responseText.message;

                            $('#md-response').addClass("alert alert-danger");
                            $('#md-response .message').html(mess+"<br/>");
                            $('#md-response').show();
                        }
                    }
                }
            })
            
        }
    });

    $(document).on('submit', 'form#feedback', function(e){

        e.preventDefault();

        let form = $(this);
        var action = form.attr('action');
        var method = form.attr('method');
        var formData = form.serializeArray();
        var sendData = new FormData();
        let errors = 0;
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };

        $.each(formData, function (key, input) {
            
            let form_input = form.find('[name="'+input.name+'"]');
            
            Helper.resetInput(form_input);
            if (form_input.attr('require') && input.value.length < 1){
                Helper.showError(form_input, 'Вы не заполнили обязательное поле');
                errors++;
            }

            if (input.value != ''){
                sendData.append(input.name, input.value);
            }
        });

        if (errors) return false;

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
                    $('#md-response .message').text(json.result);                    
                } else {
                    $('#md-response .message').text(json.error);
                }

                UIkit.modal('#md-response').show();
            },
            error :function( data ) {
                if( data.status === 422 ) {

                    var responseText = $.parseJSON(data.responseText);
                    let errors = responseText.errors;

                    if (errors){
                        $.each(errors, function (code, textError) {
                            let text = textError.join();
                            Helper.showError( form.find('[name='+code+']'), textError);
                        });
                    } else {
                        let mess = data.error ? data.error : responseText.message;

                        $('#md-response').addClass("alert alert-danger");
                        $('#md-response .message').html(mess+"<br/>");
                        $('#md-response').show();
                    }
                }
            }
        });
    });

    $('select[name="per_page"]').on('change', function(){
        let val = $(this).val();
        let urlParse = new URL(location.href);
        urlParse.searchParams.set('per_page', val);
        location.href = urlParse.href;
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
                    $('#response .message').html(data.error+"<br/>");
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