console.log('load');
const form_id = '#category_store';

$(form_id+' select[name="entity_code"]').on('change', function (){
    console.log('change');
    updCategoriesByEntity($(this).val());

})
async function updCategoriesByEntity(entity){

    let action = '/admin/category/entity?code='+entity;

    const getQuery = await fetch(action, {
        method: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });

    let jsonResponse = await getQuery.json();

    if (jsonResponse.success){

        let arCategories = jsonResponse.result;

        console.log(arCategories);

        $(form_id+' select[name="parent_id"]').empty();

        for(let key in arCategories){
            console.log(arCategories[key]);
            $(form_id+' select[name="parent_id"]').append(`<option>${arCategories[key]}</option>`);
        }

    } else {
        console.error(jsonResponse);

        UIkit.notification({
            message: jsonResponse.error,
            status: 'danger',
            timeout: 5000
        });
    }
}

$(form_id + ' [name="name"]').on('change', function (){
    if ($(this).val().length > 3){
        getTranslateCategoryName($(this).val());
    }
});
async function getTranslateCategoryName(text){

    let action = '/ajax/translate_to_code?text='+text;

    const getQuery = await fetch(action, {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });

    let jsonResponse = await getQuery.json();

    if (jsonResponse.success){
        $(form_id+' [name="code"]').val(jsonResponse.result);
    } else {
        console.error(jsonResponse);

        UIkit.notification({
            message: jsonResponse.error,
            status: 'danger',
            timeout: 5000
        });
    }
}
