$(document).ready( function () {
    $('#table_id').DataTable();
    $("table[id^='TABLE']").DataTable();
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

function add_kriteria_field() {
    var col_md_6 = document.createElement('div');
    col_md_6.setAttribute('class', 'col-md-6');

    var formGroup = document.createElement('div');
    formGroup.setAttribute('class', 'form-group');

    var input = document.createElement('input');
    input.setAttribute('type', 'text');
    input.setAttribute('id', 'kriteria_' + count_input);
    input.setAttribute('name', 'kriteria_' + count_input);
    input.setAttribute('class', "form-control <?= $rule->hasError('kriteria_" + count_input + "') ? 'is-invalid' : '' ?>");
    input.setAttribute('placeholder', 'Masukkan kode Kriteria ' + count_input);

    var invalid_feedback = document.createElement('div');
    invalid_feedback.setAttribute('class', 'invalid-feedback');
    invalid_feedback.innerHTML = "<?= $rule->getFirstError('kriteria_" + count_input + "') ?>"; // ERROR: php var become commented

    formGroup.appendChild(input);
    formGroup.appendChild(invalid_feedback);
    col_md_6.appendChild(formGroup);
    input_kriteria.appendChild(formGroup);
    count_input++;
}