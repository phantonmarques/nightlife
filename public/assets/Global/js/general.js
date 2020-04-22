window.onload = function() {
    // Alert error, timeout for display none
    alert = document.getElementById("alert-sync");

    if (typeof(alert) != 'undefined' && alert != null) {
        window.setTimeout('hideAlert(alert)', 4000);
    }

    // Select all checkbox
    $('.check-all').click(function() {
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
};

/**
 * Hide alert, after 4000 ms
 * @param alert
 */
function hideAlert(alert){
    alert.style.display = 'none';
}

