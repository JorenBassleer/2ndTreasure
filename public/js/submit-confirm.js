const ui = {
    confirm: async (message) => createConfirm(message)
}

const createConfirm = (message) => {
    return new Promise((complete, failed)=>{
        $('#confirmMessage').text(message)

        $('#confirmYes').off('click');
        $('#confirmNo').off('click');
        
        $('#confirmYes').on('click', ()=> { $('.confirm').hide(); complete(true); });
        $('#confirmNo').on('click', ()=> { $('.confirm').hide(); complete(false); });
        
        $('.confirm').show();
    });
}
                        
const saveForm = async () => {
    const confirm = await ui.confirm('Are you sure you want to delete this goodiebag?');
    
    if(confirm){
        document.getElementById('delete-form').submit();
    } else{
       
    }
}