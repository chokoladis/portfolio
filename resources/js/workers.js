
$(function(){

    $('#md-worker_new .photo input').on('change', function(){

        let file = this.files[0];
        let p = $(this).siblings('p');

        if (file){
            p.removeClass('uk-hidden');
            p.text('Текущее изображение : '+file.name);
        } else {
            p.addClass('uk-hidden');
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