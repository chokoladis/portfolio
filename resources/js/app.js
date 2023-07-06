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
            
            $.ajax({
                url: action,
                method: method,
                data: form.serialize(),
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

});