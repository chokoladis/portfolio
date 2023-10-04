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