console.log('load');
const form_id = '#category_store';

$(form_id+' select[name="entity_code"]').on('change', function (){
    console.log('change');
    updCategoriesByEntity($(this).val());

})
async function updCategoriesByEntity(entity){

    let action = 'entity/'+entity;

    const getQuery = await fetch(action, {
        method: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });

    let jsonResponse = await getQuery.json();

    console.log(jsonResponse);

    if (jsonResponse.success){

        console.log($(form_id+' select[name="parent_id"]'));

    } else {
        console.log(jsonResponse);

        UIkit.notification({
            message: jsonResponse.error,
            status: 'danger',
            timeout: 5000
        });
    }
}
