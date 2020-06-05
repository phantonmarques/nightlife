$(document).ready(function() {
    $('#time_service').datetimepicker({
        datepicker:false,
        format:'H:i'
    });

    CKEDITOR.replace('description');

    if (document.getElementById('visibleUser') !== null)
        document.getElementById('visible').value = document.getElementById('visibleUser').value;

});

function visibleInput(value) {
    if (value)
        document.getElementById('visible').value = 1;
    else
        document.getElementById('visible').value = 0;

}

function validateFormCalled(f) {
    if (f.time_service !== undefined && f.time_service.value === '') {
        swal("Erro", "O campo [Tempo atendimento] é obrigatório, favor preencha!", "error");
        return false;
    }else if (f.situation !== undefined && f.situation.value === '') {
        swal("Erro", "O campo [Situação do chamado] é obrigatório, favor selecione!", "error");
        return false;
    }else if (!f.subject.disabled && f.subject.value.trim() === '') {
        swal("Erro", "O campo [Assunto] é obrigatório, favor preencha!", "error");
        return false;
    }

    return true;
}