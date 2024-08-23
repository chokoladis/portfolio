import {Helper} from './helpers';

async function deteleMenuItem(menuId, ){
    const query = await fetch('/admin/menu/'+menuId+'/delete/', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    });

    if (query.ok) {
        const response = await query.json();

        if (response.success){
                    
            $('.links_list [data-id="'+menuId+'"]').remove();
            
            Helper.updMenuAdmin();

        } else {
            $('#response').show();
            $('#response .message').html(response.error+"<br/>");
        }

    } else {
        UIkit.notification({
            message: query.statusText,
            status: 'danger',
            timeout: 5000
        });

        throw new Error(`Response status: ${query.status}`);
    }
    
}

$(function(){

    $(document).on('click','.js_menu_del', function(){

        let parent = $(this).parents('.link');
        let menuId = parent.attr('data-id');

        deteleMenuItem(menuId);
    });

})