window.onload = function () {
    // Alert error, timeout for display none
    alert = document.getElementById("alert-sync");

    if (typeof (alert) != 'undefined' && alert != null) {
        window.setTimeout('hideAlert(alert)', 4000);
    }

    // Select all checkbox
    $('.check-all').click(function () {
        if (this.checked) {
            $('.icheck').each(function () {
                this.checked = true;
            });
        } else {
            $('.icheck').each(function () {
                this.checked = false;
            });
        }
    });

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
};

/**
 * Hide alert, after 4000 ms
 * @param alert
 */
function hideAlert(alert) {
    alert.style.display = 'none';
}


