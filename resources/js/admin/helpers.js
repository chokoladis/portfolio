import { Logger } from 'sass';
import '../bootstrap';
import jQuery, { error } from 'jquery';
window.$ = jQuery;

class Helpers {
    escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    updateWorksHtmlToAdmin(){
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
    showError(input, message, f_show = true){ // $(input)

        let parent = input.parent();
        var errorBlock = parent.find('p.error');

        if (!f_show || message == ''){
            input.removeClass('uk-form-danger');

            if (errorBlock.length){
                errorBlock.hide();
            }
        } else {
            
            input.addClass('uk-form-danger');

            if (errorBlock.length){
                errorBlock.text(message);
            } else {
                errorBlock = parent.append('<p class="error uk-text-danger">'+message+'</p>');
            }
            errorBlock.show();
        }
    }
}

export var Helper = new Helpers();