window.onload = function () {
    $("[name='connect']").on('change', function(){
        document.getElementById('formConnect').submit();
    });

    // Alert error, timeout for display none
    alert = document.getElementById('alert-sync');

    if (typeof (alert) != 'undefined' && alert != null) {
        window.setTimeout('hideAlert(alert)', 4000);
    }

    // Select all checkbox
    $('.check-all').click(function () {
        if (this.checked) {
            $('.icheck').each(function () {
                this.checked = true;
            });
            $('#displayDelete').show();
        } else {
            $('.icheck').each(function () {
                this.checked = false;
            });
            $('#displayDelete').hide();
        }
    });

    // Selected checkbox
    $('.icheck ').click(function () {
        let check = true;

        if (this.checked) {
            this.checked = true;
            $('#displayDelete').show();
        } else {
            this.checked = false;
            $('.icheck').each(function (key, value) {
                if (value.checked)
                    check = false;
            });

            if (check)
                $('#displayDelete').hide();
        }
    })

    $('.action-delete').click(function(e){
        e.preventDefault();
        const url = $(this).attr('href');

        let contentButton = "Você não poderá reverter isso!";
        let actionButton = "Excluir";

        if ($(this).attr('data-title') === 'establishment'){
            contentButton = "Você poderá reativar novamente!";
            actionButton = "Desativar";
        }

        swal({
            title: 'Tem certeza?',
            text: contentButton,
            icon: "warning",
            dangerMode: true,
            buttons: {
                cancel: {
                    text: "Cancelar",
                    value: false,
                    visible:true,
                },
                confirm: {
                    text: actionButton,
                    value: true,
                    visible:true,
                },
            }
        }).then((status) => {
            if (status) {
                swal({
                    title: "Excluído com sucesso!",
                    icon: "success",
                });
                setTimeout(function(){
                    window.location.href = url;
                }, 3000);


            }
        });
    });

    $('#deleteSelected').click(function(e){
        e.preventDefault();
        const url = $(this).attr('href');

        let contentButton = 'Você não poderá reverter isso!';
        let contentText = 'Tem certeza que deseja excluir todos selecionados?';
        let actionButton = 'Excluir';

        if ($(this).attr('data-title') === 'establishment'){
            contentButton = "Você poderá reativar novamente!";
            contentText = 'Tem certeza que deseja desativar todos selecionados?';
            actionButton = "Desativar";
        }

        let ids = [];

        $('.icheck').each(function () {
            if (this.checked && this.value > 0)
                ids.push(this.value);
        });

        swal({
            title: contentText,
            text: contentButton,
            icon: "warning",
            dangerMode: true,
            buttons: {
                cancel: {
                    text: 'Cancelar',
                    value: false,
                    visible:true,
                },
                confirm: {
                    text: actionButton,
                    value: true,
                    visible:true,
                },
            }
        }).then((status) => {
            if (status) {
                $.ajax({
                    url: url,
                    headers: {
                        'X-CSRF-Token': document.getElementsByTagName('meta')[2].getAttribute('content')
                    },
                    type: 'DELETE',
                    data: { ids: ids },
                    success: function(data) {
                        if (data.status)
                            swal({
                                title: data.message,
                                icon: 'success',
                            });
                        else 
                            swal({
                                title: data.message,
                                icon: 'error',
                            });
                    },
                    error: function() {
                        swal({
                            title: 'Desconhecido, favor recarrega a página e tente novamente!',
                            icon: 'error',
                        });
                    },
                });

                setTimeout(function(){
                    $('.icheck').each(function (key, value) {
                        value.checked = false;
                    });

                    window.location.reload();
                }, 3000);
            }
        });
    });
};

/**
 * Hide alert, after 4000 ms
 * @param alert
 */
function hideAlert(alert) {
    alert.style.display = 'none';
}


