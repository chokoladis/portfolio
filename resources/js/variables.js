import { Logger } from 'sass';
import './bootstrap';
import jQuery, { error } from 'jquery';
window.$ = jQuery;

class Helpers {
    // make full script file special for admin
    updWorksAdmin(){
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
    updMenuAdmin(){
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