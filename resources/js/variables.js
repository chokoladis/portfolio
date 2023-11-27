import { Logger } from 'sass';
import './bootstrap';
import jQuery, { error } from 'jquery';
window.$ = jQuery;

class Helpers {
    updWorks(data = null){
        if (data){
            let works = $(data).find('main .works_list > *');
            let paginastion  = $(data).find('main .paginastion > *');
            $('main .works_list').html(works);
            $('main .paginastion').html(paginastion);
        } else {
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
        }
        
    };
    resetInput(input){
        let parent = input.parent();
        var errorBlock = parent.find('p.error');

        input.removeClass('uk-form-danger');

        if (errorBlock.length){
            errorBlock.hide();
        }
    };
    showError(input, messsage, f_show = true){ // $(input)

        let parent = input.parent();
        var errorBlock = parent.find('p.error');

        if (!f_show || messsage == ''){
            input.removeClass('uk-form-danger');

            if (errorBlock.length){
                errorBlock.hide();
            }
        } else {
            
            input.addClass('uk-form-danger');

            if (errorBlock.length){
                errorBlock.text(messsage);
            } else {
                errorBlock = parent.append('<p class="error uk-text-danger">'+messsage+'</p>');
            }
            errorBlock.show();
        }
    }
}

export var Helper = new Helpers();