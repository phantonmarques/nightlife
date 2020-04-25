$(document).ready(function() {
    CKEDITOR.replace('description');

    document.querySelector("html").classList.add('js');

    var fileInput  = document.querySelector( ".input-file" ),
        button     = document.querySelector( ".input-file-trigger" ),
        the_return = document.querySelector(".file-return");

    button.addEventListener( "keydown", function( event ) {
        if ( event.keyCode == 13 || event.keyCode == 32 ) {
            fileInput.focus();
        }
    });
    button.addEventListener( "click", function( event ) {
        fileInput.focus();
        return false;
    });
    fileInput.addEventListener( "change", function( event ) {
        the_return.innerHTML = this.files[0].name;
    });

    if (fileInput.value !== '')
        the_return.innerHTML = fileInput.files[0].name;

    $.datepicker.regional['pt-BR'] = {
        closeText: 'Fechar',
        prevText: '&#x3c;Anterior',
        nextText: 'Pr&oacute;ximo&#x3e;',
        currentText: 'Hoje',
        monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
            'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
            'Jul','Ago','Set','Out','Nov','Dez'],
        dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
        dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
        weekHeader: 'Sem',
        dateFormat: 'dd/mm/yy',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

    $( "#datepicker" ).datepicker({minDate: 0}).datepicker("setDate", "0");

    $('.money').mask('#.##0,00', {reverse: true});

    if ($('#date_event').val() !== ''){
        $( "#datepicker" ).val($('#date_event').val());
        FillDate($( "#datepicker" ).val());
    }else{
        FillDate($( "#datepicker" ).val());
    }
});

function onlyNumbers(e) {
    var charCode = e.charCode ? e.charCode : e.keyCode;

    if (charCode != 8 && charCode != 9) {
        if (charCode < 48 || charCode > 57) {
            return false;
        }
    }
}

function FillDate(data) {
    var day  = data.split("/")[0];
    var month  = data.split("/")[1];
    var year  = data.split("/")[2];

    document.getElementById('date_event').value = year + '-' + ("0"+month).slice(-2) + '-' + ("0"+day).slice(-2);
}

function validateFormEvent(f) {
    if (f.name.value.length === 0 || f.name.value === '') {
        swal("Erro", "O campo [Nome] é obrigatório, favor preencha!", "error");
        return false;
    }else if (f.date_event.value.length === 0 || f.date_event.value === '') {
        swal("Erro", "O campo [Data Evento] é obrigatório, favor selecione!", "error");
        return false;
    }else if (f.establishment_address_id.value.length === 0 || f.establishment_address_id.value === '') {
        swal("Erro", "O campo [Endereço do Estabelecimento] é obrigatório, favor selecione!", "error");
        return false;
    }else if (f.price.value.length === 0 || f.price.value === '') {
        swal("Erro", "O campo [Preço Evento] é obrigatório, favor preencha!", "error");
        return false;
    }

    $('.money').mask('##0.00', {reverse: true});

    return true;
}