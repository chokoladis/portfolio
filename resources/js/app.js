import './bootstrap';

import jQuery from 'jquery';
window.$ = jQuery;

$(function(){

    $('form [type="submit"]').on('click', function(e){

        let form = $(this).parent('form');
        let ajax = form.find('input[name="AJAX"]');
        
        if (ajax.length && ajax.val() == 'Y' ){
            
            e.preventDefault();
            
            let action = form.attr('action');
            let method = form.attr('method');
            let formData = form.serializeArray();
            let sendData = new FormData();

            $.each(formData, function (key, input) {
                sendData.append(input.name, input.value);
            });
            
            var file_data = $('input[name="url_files"]')[0].files;

            for (var i = 0; i < file_data.length; i++) {
                sendData.append("url_files[]", file_data[i]);
            }


            
            console.log(file_data);
            console.log(sendData);
            

            $.ajax({
                url: action,
                method: method,
                data: sendData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(json){
                    console.log(json);
                },
                error :function( data ) {
                    if( data.status === 422 ) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            // console.log(key+ " " +value);
                        $('#response').addClass("alert alert-danger");
            
                            if($.isPlainObject(value)) {
                                $.each(value, function (key, value) {                       
                                    console.log(key+ " " +value);
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

    // $('.work').on('mouseover', function(){
    //     setTimeout(() => {$(this).addClass('hovered') }, 1000);
    // });

    // $('.work').on('mouseout', function(){
    //     setTimeout(() => {$(this).removeClass('hovered')}, 1000);
    // });

    

});