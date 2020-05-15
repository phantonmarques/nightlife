$(document).ready(function () {
    $('.phone').mask('(00) 00000-0000');
    $('.cep').mask('00000-000');

    if (document.getElementById('complement').disable) {
        document.getElementById('complement').disable = false;
    }

    if (document.getElementById('zip_code').value !== '')
        searchZipCode();

    if (document.getElementById('contContact').value > 1){
        for (let a = document.getElementById('contContact').value; a > 1; a--){
            if (document.getElementById('name_' + a) !== null){
                document.getElementById('contContact').value = (a-1);
                break;
            }else if (a === 2){
                document.getElementById('contContact').value = 1;
            }
        }
    }

    $("#add").click(function() {
        let contContacts = parseInt(document.getElementById('contContact').value);

        $("#info-contact").append(
            '<div class="row" id="r_name_'+ contContacts +'">' +
                '<br><br>' +
                '<div class="col-lg-3">' +
                    '<label for="name_'+ contContacts +'">Nome Contato '+ contContacts +'</label>' +
                    '<input placeholder="Informe nome do contato." class="form-control" name="contact['+contContacts+'][name]" type="text" value="" id="name_'+ contContacts +'" maxlength="9">' +
                '</div>' +
            '</div>' +
            '<div class="row" id="r_phone_'+ contContacts +'">' +
                '<br>' +
                '<div class="col-lg-2">'+
                    '<label for="phone_'+ contContacts +'">Telefone '+ contContacts +'</label>' +
                    '<div class="input-group">' +
                        '<div class="input-group-addon">' +
                            '<i class="fa fa-user"></i>' +
                        '</div>' +
                        '<input class="form-control phone" onkeypress="return onlyNumbers(event)" name="contact['+contContacts+'][phone]" type="text" value="" id="phone_'+ contContacts +'" maxlength="15">' +
                    '</div>' +
                '</div>' +
                '<div class="col-lg-2">' +
                    '<label for="Número tem Whatsapp">Número Tem Whatsapp</label>' +
                        '<div class="input-group">' +
                            '<span class="input-group-addon">' +
                                '<input id="whatsapp_'+ contContacts +'" name="contact['+contContacts+'][whatsapp]" type="checkbox" value="1">' +
                            '</span>' +
                            '<label for="whatsapp_'+ contContacts +'" class="form-control">Sim</label>' +
                        '</div>' +
                '</div>' +
            '</div>'
        );

        document.getElementById('contContact').value = contContacts + 1;

        $('.phone').mask('(00) 00000-0000');
    });

    $("#del").click(function() {
        let contContacts = parseInt(document.getElementById('contContact').value) - 1;

        if (contContacts > 0){
            // Seleciona a div que está os contatos
            let divInf = document.getElementById("info-contact");

            // Remove últimos elementos da div.
            let name = document.getElementById('r_name_'+ contContacts);
            let phone = document.getElementById('r_phone_'+ contContacts);

            divInf.removeChild(name);
            divInf.removeChild(phone);

            document.getElementById('contContact').value = contContacts;
        }
    });


});

function searchZipCode(type = '') {
    let cep = $('#zip_code').cleanVal();

    if (cep.length === 8) {
        $.ajax({
            url: "https://viacep.com.br/ws/" + cep + "/json/",
            type: 'GET',
            crossDomain: true,
            dataType: 'jsonp',
            success: function (data) {
                if (typeof (data.logradouro) != "undefined") {
                    document.getElementById("addressEstablishment").style.display = "block";
                    document.getElementById("street_name").value = data.logradouro;
                    document.getElementById("neighborhood").value = data.bairro;
                    searchState(data.uf);
                    setTimeout(function() {
                        var city = data.localidade;
                        searchCity(removeAccentsSpace(city));
                    }, (500));

                    document.getElementById("city_id").disabled = true;
                    if (type !== '') {
                        document.getElementById('building_number').value = '';
                        document.getElementById('complement').value = '';
                    }


                } else {
                    document.getElementById("addressEstablishment").style.display = "none";
                    document.getElementById('building_number').value = '';
                    document.getElementById('complement').value = '';
                    swal("Erro", "Cep não localizado!", "error");

                }
            },
            error: function () {
                document.getElementById("addressEstablishment").style.display = "none";
                document.getElementById('building_number').value = '';
                document.getElementById('complement').value = '';
                swal("Erro", "Desconhecido, favor recarrega a página e tente novamente!", "error");
            },
        });
    } else if (cep.length === 0) {
        document.getElementById("addressEstablishment").style.display = "none";
        document.getElementById('building_number').value = '';
        document.getElementById('complement').value = '';
        swal("Erro", "Favor preencha o cep!", "error");
    } else {
        document.getElementById("addressEstablishment").style.display = "none";
        document.getElementById('building_number').value = '';
        document.getElementById('complement').value = '';
        swal("Erro", "Cep incompleto, favor verifique e tente novamente!", "error");
    }

}

function searchCity(index = '') {
    let state = document.getElementById('state_id').value;

    if (state.length > 0) {
        $.ajax({
            url: document.getElementById('url_city').value + state,
            type: 'GET',
            crossDomain: true,
            success: function (data) {
                if (typeof (data[0].id) !== undefined) {
                    var selectCidades = document.getElementById("city_id");

                    $('#city_id').empty();

                    for (var k in data) {
                        var option = document.createElement("option");
                        option.value = data[k].id;
                        option.text = data[k].name_visible;
                        selectCidades.add(option);

                        if (index !== '' && data[k].name === index || index !== '' && data[k].id === parseInt(index)) {
                            selectCidades.value = data[k].id;
                        }
                    }
                }
            },
            error: function () {
                swal("Erro", "Desconhecido, favor recarrega a página e tente novamente!", "error");
            },
        });
    } else if (state.length === 0) {
        swal("Erro", "Selecione o estado e tente novamente!", "error");
    }
}

function searchState(state) {
    if (state.length > 0) {
        $.ajax({
            url: document.getElementById('url_state').value + state,
            type: 'GET',
            crossDomain: true,
            success: function (data) {
                if (data.id !== '' && data.id !== undefined)
                    document.getElementById("state_id").value = data.id;
                    document.getElementById("state_id").disabled = true;
            },
            error: function () {
                swal("Erro", "Desconhecido, favor recarrega a página e tente novamente!", "error");
            },
        });
    }
}

function removeAccentsSpace(text) {
    text = text.toLowerCase();
    text = text.replace(new RegExp('[ÁÀÂÃ]', 'gi'), 'a');
    text = text.replace(new RegExp('[ÉÈÊ]', 'gi'), 'e');
    text = text.replace(new RegExp('[ÍÌÎ]', 'gi'), 'i');
    text = text.replace(new RegExp('[ÓÒÔÕ]', 'gi'), 'o');
    text = text.replace(new RegExp('[ÚÙÛ]', 'gi'), 'u');
    text = text.replace(new RegExp('[Ç]', 'gi'), 'c');
    text = text.replace(/ /g, '-');
    return text;
}

function onlyNumbers(e) {
    var charCode = e.charCode ? e.charCode : e.keyCode;

    if (charCode != 8 && charCode != 9) {
        if (charCode < 48 || charCode > 57) {
            return false;
        }
    }
}

function validateFormEstablishmentAddress(f) {
    if (f.zip_code.value.length === 0 || f.zip_code.value.trim() === '') {
        swal("Erro", "O campoo [CEP] é obrigatório, favor preencha!", "error");
        return false;
    } else if (f.street_name.value.length === 0 || f.street_name.value.trim() === '') {
        swal("Erro", "Cep inválido ou não localizado, insira e clique em [Buscar]!", "error");
        return false;
    } else if (f.building_number.value.length === 0 || f.building_number.value.trim() === '') {
        swal("Erro", "O campo [Número] é obrigatório, favoor preencha!", "error");
        return false;
    } else if (f.state_id.value.length === 0 || f.state_id.value.trim() === '') {
        swal("Erro", "O campo [Estado] é obrigatório, favor preencha!", "error");
        return false;
    }else if (f.city_id.value.length === 0 || f.city_id.value.trim() === '') {
        swal("Erro", "O campo [Cidade] é obrigatório, favor preencha!", "error");
        return false;
    }else if (f.neighborhood.value.length === 0 || f.neighborhood.value.trim() === '') {
        swal("Erro", "O campo [Bairro] é obrigatório, favor preencha!", "error");
        return false;
    }else if (!f.elements["contact[0][name]"].value.length || f.elements["contact[0][name]"].value.trim() === '') {
        swal("Erro", "O campo [Nome Contato] é obrigatório, favor preencha!", "error");
        return false;
    } else if (!f.elements["contact[0][phone]"].value.length || f.elements["contact[0][phone]"].value.trim() === '') {
        swal("Erro", "O campo [Telefone] é obrigatório, favor preencha!", "error");
        return false;
    }else if (f.elements["contact[0][name]"].value.length < 2) {
        swal("Erro", "O campo [Nome Contato] é obrigatório e deve conter no mínimo 3 caracteres, favor preencha corretamente!", "error");
        return false;
    } else if (f.elements["contact[0][phone]"].value.length < 10) {
        swal("Erro", "O campo [Telefone] é obrigatório e deve conter no mínimo 11 números, favor preencha corretamente!", "error");
        return false;
    }

    if (f.complement.value.length === 0 || f.complement.value.trim() === '') {
        f.complement.disabled = true;
    }

    if (f.city_id.disabled) {
        f.state_id.disabled = false;
        f.city_id.disabled = false;
    }

    $('.cep').unmask();

    return true;
}
