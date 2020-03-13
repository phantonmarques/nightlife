window.onload = function() {
    $("#cnpjEstablishment").mask("99.999.999/9999-99");

    selectUser(document.getElementById('user_id').value);
};

function searchInformationCompany() {
    let cnpjEstab = $("#cnpjEstablishment").cleanVal().trim();

    if (cnpjEstab.length === 14){
        $.ajax({
            url: "https://www.receitaws.com.br/v1/cnpj/"+ cnpjEstab,
            type: 'GET',
            crossDomain: true,
            dataType: 'jsonp',
            success: function(data) {
                if (typeof(data.situacao) != "undefined") {
                    document.getElementById("situationEstablishment").innerHTML = 'Situação Empresa: ' + data.situacao;
                    document.getElementById("statusEstablishment").innerHTML  = 'Status Empresa: ' + data.status;
                    document.getElementById("openedEstablishment").innerHTML = 'Data Abertura: ' + data.abertura;
                    document.getElementById("infReceita").style.backgroundColor = '#C2F9C7';
                }else {
                    document.getElementById("situationEstablishment").innerHTML = '';
                    document.getElementById("statusEstablishment").innerHTML  = 'Dados não encontrados ou inválidos';
                    document.getElementById("openedEstablishment").innerHTML = '';
                    document.getElementById("infReceita").style.backgroundColor = '#F35658';
                }
            },
            error: function() {
                document.getElementById("situationEstablishment").innerHTML = '';
                document.getElementById("statusEstablishment").innerHTML  = '';
                document.getElementById("openedEstablishment").innerHTML = '';
                document.getElementById("infReceita").style.backgroundColor = 'white';
                swal("Erro", "Desconhecido, favor recarrega a página e tente novamente!", "error");
            },
        });
    }else if (cnpjEstab.length === 0){
        document.getElementById("situationEstablishment").innerHTML = '';
        document.getElementById("statusEstablishment").innerHTML  = '';
        document.getElementById("openedEstablishment").innerHTML = '';
        document.getElementById("infReceita").style.backgroundColor = 'white';
        swal("Erro", "Favor preencha o cnpj do Estabelecimento!", "error");
    }else {
        document.getElementById("situationEstablishment").innerHTML = '';
        document.getElementById("statusEstablishment").innerHTML  = '';
        document.getElementById("openedEstablishment").innerHTML = '';
        document.getElementById("infReceita").style.backgroundColor = 'white';
        swal("Erro", "Cnpj incompleto, favor verifique e tente novamente!", "error");
    }
}

function selectUser(user) {
    if (user !== ''){
        document.getElementById('divEmail').style.display = 'flex';
        document.getElementById('divLogin').style.display = 'flex';
        document.getElementById('divCnpj').style.display  = 'flex';
        document.getElementById('userEmail').value = user;
        document.getElementById('userLogin').value = user;
        document.getElementById('userCNPJ').value  = user;
    }else {
        document.getElementById('divEmail').style.display = 'none';
        document.getElementById('divLogin').style.display = 'none';
        document.getElementById('divCnpj').style.display  = 'none';
    }
}

function somenteNumeros(e) {
    var charCode = e.charCode ? e.charCode : e.keyCode;
    if (charCode != 8 && charCode != 9) {
        if (charCode < 48 || charCode > 57) {
            return false;
        }
    }
}

function validateFormEstablishment(f) {
    if (f.corporate_name.value === ''){
        swal("Erro", "O campo [Razão Social] é obrigatório, favor preencha!", "error");
        return false;
    }else if (f.state_registration.value === ''){
        swal("Erro", "O campo [Inscrição Estadual] é obrigatório, favor preencha!", "error");
        return false;
    }else if (f.type_license.value === ''){
        swal("Erro", "O campo [Tipo Conta] é obrigatório, favor preencha!", "error");
        return false;
    }else if (f.status.value === ''){
        swal("Erro", "[Status Estabelecimento] é obrigatório, favor selecione!", "error");
        return false;
    }else if (f.user_id.value === ''){
        swal("Erro", "[Nome Usuário] é obrigatório, favor selecione!", "error");
        return false;
    }

    $("#cnpjEstablishment").unmask();

    return true;
}