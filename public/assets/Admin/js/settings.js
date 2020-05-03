$(document).ready(function () {
    if (document.querySelector( ".input-file" ) !== null){
        document.querySelector("html").classList.add('js');

        let fileInput  = document.querySelector( ".input-file" ),
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
    }

    // Click event of the viewPassword button
    $('#viewPasswordRecent').on('click', function () {

        // Get the password field
        var passwordField = $('#recent_password');

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

    let typingTimer; // timer identifier
    let doneTypingInterval = 1000; // time in ms, 1 second for example


    // on keyup, start the countdown
    $('#recent_password').keyup(function() {
        clearTimeout(typingTimer);
        if ($('#recent_password').val) {
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        }
    });
});

// user is "finished typing," do something
function doneTyping() {
    $.ajax({
        url: $('#url_valid').val() + '/' + $('#recent_password').val(),
        type: 'GET',
        crossDomain: true,
        success: function (data) {
            if (data.status){
                $('#alertPassword').hide();
                $('#divPassword').show();
                $('#divPasswordConfirm').show();
                $('#bt_salvar').show();
                $('#recent_password').attr('disabled', true);
            }else{
                $('#alertPassword').show();
            }
        },
        error: function () {
            swal("Erro", "Desconhecido, favor recarrega a página e tente novamente!", "error");
        },
    });
}

function validateFormPasswordReset(f) {
    if (f.password.value.length === 0 || f.password.value.trim() === '') {
        swal("Erro", "O campo [Nova Senha] é obrigatório, favor preencha!", "error");
        return false;
    } else if (f.confirm_password.value.length === 0 || f.confirm_password.value.trim() === '') {
        swal("Erro", "O campo [Confirme nova Senha] é obrigatório, favor preencha!", "error");
        return false;
    } else if (f.password.value !== f.confirm_password.value) {
        swal("Erro", "Senha e confirmação não iguais, favor verifique!", "error");
        return false;
    }

    return true;
}
