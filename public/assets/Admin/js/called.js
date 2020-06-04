$(document).ready(function() {
    $('#time_service').datetimepicker({
        datepicker:false,
        format:'H:i'
    });

    CKEDITOR.replace('description');

});

function validateFormCalled(f) {
    // if (f.name.value.length === 0 || f.name.value.trim() === '') {
    //     swal("Erro", "O campo [Nome] é obrigatório, favor preencha!", "error");
    //     return false;
    // }else if (f.date_event.value.length === 0 || f.date_event.value.trim() === '') {
    //     swal("Erro", "O campo [Data Evento] é obrigatório, favor selecione!", "error");
    //     return false;
    // }else if (f.establishment_address_id.value.length === 0 || f.establishment_address_id.value.trim() === '') {
    //     swal("Erro", "O campo [Endereço do Estabelecimento] é obrigatório, favor selecione!", "error");
    //     return false;
    // }else if (f.price.value.length === 0 || f.price.value.trim() === '') {
    //     swal("Erro", "O campo [Preço Evento] é obrigatório, favor preencha!", "error");
    //     return false;
    // }

    console.log(f.subject.value)
    console.log(f.subject.disabled)
    console.log('invalid')
    return false;
}