import { Logger } from 'sass';
import './bootstrap';
import jQuery, { error } from 'jquery';
window.$ = jQuery;

class Helpers {
    updateWorksHtml(data = null){
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
    updWorkersHtml(data){
        if (data){
            let workers = $(data).find('main .workers_list > *');
            let paginastion  = $(data).find('main .paginastion > *');
            $('main .workers_list').html(workers);
            $('main .paginastion').html(paginastion);
        } else {
            $.ajax({
                url: location.href,
                method: 'GET',
                success: function(html){
                    let workers = $(html).find('main .workers_list > *');
                    let paginastion  = $(html).find('main .paginastion > *');
                    $('main .workers_list').html(workers);
                    $('main .paginastion').html(paginastion);
                }
            });
        }
    }
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