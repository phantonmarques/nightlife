window.onload = function() {
    alert = document.getElementById("alert-sync");

    if (typeof(alert) != 'undefined' && alert != null) {
        window.setTimeout('hideAlert(alert)', 4000);
    }
};

function hideAlert(alert){
    alert.style.display = 'none';
}