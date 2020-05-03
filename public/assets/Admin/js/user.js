$(document).ready(function () {
    $('.cep').mask('00000-000');

    if (document.getElementById('password').disabled)
        document.getElementById('password').disabled = false;

    if ($('#type_user').val() === 'u')
        $('#user_role').prop("disabled", true);

    if ($('#city').val() !== '')
        searchCity($('#city').val());
    else if ($('#state_id').val() !== '')
        searchCity();

    var cpfMask = function (val) {
            return val.replace(/\D/g, '').length > 11 ? '00.000.000/0000-00' : '000.000.000-009';
        },
        cpfOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(cpfMask.apply({}, arguments), options);
            }
        };
    $('#cpf_cnpj').mask(cpfMask, cpfOptions);

    // Click event of the viewPassword button
    $('#viewPassword').on('click', function () {

        // Get the password field
        var passwordField = $('#password');

        // Get the current type of the password field will be password or text
        var passwordFieldType = passwordField.attr('type');

        // Check to see if the type is a password field
        if (passwordFieldType == 'password') {
            // Change the password field to text
            passwordField.attr('type', 'text');

            $(this).removeClass('fas fa-eye');
            $(this).addClass('fas fa-eye-slash');
        } else {
            // If the password field type is not a password field then set it to password
            passwordField.attr('type', 'password');

            $(this).removeClass('fas fa-eye-slash');
            $(this).addClass('fas fa-eye');
        }
    });

    // Click event of the viewPassword button
    $('#viewPasswordConfirm').on('click', function () {

        // Get the password field
        var passwordField = $('#confirm_password');

        // Get the current type of the password field will be password or text
        var passwordFieldType = passwordField.attr('type');

        // Check to see if the type is a password field
        if (passwordFieldType == 'password') {
            // Change the password field to text
            passwordField.attr('type', 'text');

            $(this).removeClass('fas fa-eye');
            $(this).addClass('fas fa-eye-slash');
        } else {
            // If the password field type is not a password field then set it to password
            passwordField.attr('type', 'password');

            $(this).removeClass('fas fa-eye-slash');
            $(this).addClass('fas fa-eye');
        }
    });

    // Click event of the type user select
    $('#type_user').on('change', function () {
        if ($(this).val() === 'u')
            $('#user_role').prop("disabled", true);
        else
            $('#user_role').removeAttr("disabled");
    });


});

function onlyNumbers(e) {
    var charCode = e.charCode ? e.charCode : e.keyCode;

    if (charCode != 8 && charCode != 9) {
        if (charCode < 48 || charCode > 57) {
            return false;
        }
    }
}

function searchLocation() {
    let cep = $('#zip_code').cleanVal();

    if (cep.length === 8) {
        $.ajax({
            url: "https://viacep.com.br/ws/" + cep + "/json/",
            type: 'GET',
            crossDomain: true,
            dataType: 'jsonp',
            success: function (data) {
                if (typeof (data.logradouro) != "undefined") {
                    searchState(data.uf);
                    setTimeout(function() {
                        var city = data.localidade;
                        searchCity(removeAccentsSpace(city));
                    }, (500));
                } else {
                    swal("Erro", "Cep não localizado!", "error");

                }
            },
            error: function () {
                swal("Erro", "Desconhecido, favor recarrega a página e tente novamente!", "error");
            },
        });
    } else if (cep.length === 0) {
        swal("Erro", "Favor preencha o cep!", "error");
    } else {
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
                    document.getElementById("state_id").value = data.id
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

function validateEmail(str) {
    var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return pattern.test(str);  // returns a boolean
}

function validateCpfCnpj(val) {
    if (val.length == 14) {
        var cpf = val.trim()

        cpf = cpf.replace(/\./g, '');
        cpf = cpf.replace('-', '');
        cpf = cpf.split('');

        var v1 = 0;
        var v2 = 0;
        var aux = false;

        for (var i = 1; cpf.length > i; i++) {
            if (cpf[i - 1] != cpf[i]) {
                aux = true;
            }
        }

        if (aux == false) {
            return false;
        }

        for (var i = 0, p = 10; (cpf.length - 2) > i; i++, p--) {
            v1 += cpf[i] * p;
        }

        v1 = ((v1 * 10) % 11);

        if (v1 == 10) {
            v1 = 0;
        }

        if (v1 != cpf[9]) {
            return false;
        }

        for (var i = 0, p = 11; (cpf.length - 1) > i; i++, p--) {
            v2 += cpf[i] * p;
        }

        v2 = ((v2 * 10) % 11);

        if (v2 == 10) {
            v2 = 0;
        }

        if (v2 != cpf[10]) {
            return false;
        } else {
            return true;
        }
    } else if (val.length == 18) {
        var cnpj = val.trim();

        cnpj = cnpj.replace(/\./g, '');
        cnpj = cnpj.replace('-', '');
        cnpj = cnpj.replace('/', '');
        cnpj = cnpj.split('');

        var v1 = 0;
        var v2 = 0;
        var aux = false;

        for (var i = 1; cnpj.length > i; i++) {
            if (cnpj[i - 1] != cnpj[i]) {
                aux = true;
            }
        }

        if (aux == false) {
            return false;
        }

        for (var i = 0, p1 = 5, p2 = 13; (cnpj.length - 2) > i; i++, p1--, p2--) {
            if (p1 >= 2) {
                v1 += cnpj[i] * p1;
            } else {
                v1 += cnpj[i] * p2;
            }
        }

        v1 = (v1 % 11);

        if (v1 < 2) {
            v1 = 0;
        } else {
            v1 = (11 - v1);
        }

        if (v1 != cnpj[12]) {
            return false;
        }

        for (var i = 0, p1 = 6, p2 = 14; (cnpj.length - 1) > i; i++, p1--, p2--) {
            if (p1 >= 2) {
                v2 += cnpj[i] * p1;
            } else {
                v2 += cnpj[i] * p2;
            }
        }

        v2 = (v2 % 11);

        if (v2 < 2) {
            v2 = 0;
        } else {
            v2 = (11 - v2);
        }

        if (v2 != cnpj[13]) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function validateFormUser(f) {
    if (f.name.value.length === 0 || f.name.value.trim() === '') {
        swal("Erro", "O campo [Nome] é obrigatório, favor preencha!", "error");
        return false;
    } else if (f.email.value.length === 0 || f.email.value.trim() === '') {
        swal("Erro", "O campo [E-mail] é obrigatório, favor preencha!", "error");
        return false;
    } else if (f.cpf_cnpj.value.length === 0 || f.cpf_cnpj.value.trim() === '') {
        swal("Erro", "O campo [CPF/CNPJ] é obrigatório, favor preencha!", "error");
        return false;
    } else if (!validateEmail(f.email.value)) {
        swal("Erro", "E-mail inválido, favor digite outro!", "error");
        return false;
    } else if (!validateCpfCnpj(f.cpf_cnpj.value)) {
        swal("Erro", "Cpf/Cnpj inválido, favor digite outro!", "error");
        return false;
    } else if (f.type_user.value.length === 0 || f.type_user.value.trim() === '') {
        swal("Erro", "O campo [Tipo Usuário] é obrigatório, favor preencha!", "error");
        return false;
    } else if ((f.password.value.length === 0 || f.password.value.trim() === '') && f.city.value.trim() === '') {
        swal("Erro", "O campo [Nova Senha] é obrigatório, favor preencha!", "error");
        return false;
    } else if ((f.confirm_password.value.length === 0 || f.confirm_password.value.trim() === '') && f.city.value.trim() === '') {
        swal("Erro", "O campo [Confirme nova Senha] é obrigatório, favor preencha!", "error");
        return false;
    } else if (f.password.value !== f.confirm_password.value) {
        swal("Erro", "Senha e confirmação não iguais, favor verifique!", "error");
        return false;
    } else if (f.state_id.value.length === 0 || f.state_id.value.trim() === '') {
        swal("Erro", "O campo [Estado] é obrigatório, favor preencha!", "error");
        return false;
    } else if (f.city_id.value.length === 0 || f.city_id.value.trim() === '') {
        swal("Erro", "O campo [Cidade] é obrigatório, favor preencha!", "error");
        return false;
    } else if (f.password.value.trim() === '' && f.confirm_password.value.trim() === '' && f.city.value !== ''){
        f.password.disabled = true;
    }

    $('#cpf_cnpj').unmask();

    return true;
}