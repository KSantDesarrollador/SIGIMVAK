$(document).ready(function () {
    $.ajaxSetup({
        cache: false
    });

    $('a[data-modal]').on('click', function (e) {

        openmodal(this.href);
        return false;
    });
    $('#ModalMaster').on('hidden.bs.modal', function () {
        $('#ContentModalMaster').html('');
    })
});

function openmodal(url) {

    $('#ContentModalMaster').load(url, function () {
        $('#ModalMaster').modal({
            keyboard: true
        }, 'show');

        bindForm(this);
    });
}

function bindForm(dialog) {

    $('form', dialog).submit(function () {
        if ($(this).valid()) {

            $.ajax({
                url: this.action,
                type: this.method,
                data: $(this).serialize(),
                success: function (result) {

                    if (result.success) {
                        alert("Transaction Successful");
                        window.location = window.location;

                    } else {
                        alert("Error in Transaction \n Not Save");
                        $('#ContentModalMaster').html(result);
                        bindForm();
                    }
                }
            });
            return false;
        } else {
            return false;
        }
    });
}