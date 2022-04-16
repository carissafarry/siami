$(document).ready( function () {
    $('#table_id').DataTable({
    });
} );

function setAlert(message, type) {
    let icon = 'fa fa-times';
    if (type === 'success') {
        icon = 'fa fa-check';
    }
    let alert = $.notify({
        icon: icon,
        message: message,
    }, {
        type: type
    });
    setTimeout(function() {
        alert.close();
    }, 2500);
}