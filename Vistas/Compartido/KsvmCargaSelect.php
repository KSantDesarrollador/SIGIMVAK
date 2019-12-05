<script type="text/javascript">
    /*Cargar Select */
$(document).ready(function(){
    /**Método para cargar país*/

    $.ajax({
		type: 'POST',
        url: '<?php echo KsvmServUrl;?>Ajax/KsvmPaisAjax.php'
        })
        .done(function (CargaLista) {
            $('#KsvmCargaListaPais').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
    });
    /**Método para cargar provincia*/
    $('#KsvmCargaListaPais').on('change', function () {
        var KsvmId = $('#KsvmCargaListaPais').val()
        if (KsvmId != "") {
            $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmProvinciaAjax.php',
            data: {'id': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmCargaListaProvincia').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /**Método para cargar cantón*/
    $('#KsvmCargaListaProvincia').on('change', function () {
        var KsvmId = $('#KsvmCargaListaProvincia').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmCantonAjax.php',
            data: {'id': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmCargaListaCanton').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /**Método para cargar parroquia*/
    $('#KsvmCargaListaCanton').on('change', function () {
        var KsvmId = $('#KsvmCargaListaCanton').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmParroquiaAjax.php',
            data: {'id': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmCargaListaParroquia').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
        /**Método para cargar Medicamento*/
        $('#KsvmCmpId').on('change', function () {
        var KsvmId = $('#KsvmCmpId').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmComprasAjax.php',
            data: {'KsvmCmpCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmDocId').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
        /**Método para cargar Stock*/
        $('#KsvmDocId').on('change', function () {
        var KsvmId = $('#KsvmDocId').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmComprasAjax.php',
            data: {'KsvmDocCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmStockEx').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /**Método para cargar Existencias*/
    $('#KsvmBdgExt').on('change', function () {
        var KsvmId = $('#KsvmBdgExt').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmExistenciasAjax.php',
            data: {'KsvmBdgCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmExtId').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /**Método para cargar Stock*/
    $('#KsvmExtId').on('change', function () {
        var KsvmId = $('#KsvmExtId').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmExistenciasAjax.php',
            data: {'KsvmExtCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmStockInv').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /**Método para cargar Inventario*/
    $('#KsvmBdgInv').on('change', function () {
        var KsvmId = $('#KsvmBdgInv').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmInventarioAjax.php',
            data: {'KsvmBdgCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmIvtId').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /**Método para cargar Medicamento*/
    $('#KsvmIvtId').on('change', function () {
        var KsvmId = $('#KsvmIvtId').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmInventarioAjax.php',
            data: {'KsvmIvtMedCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmExtId').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /**Método para cargar Stock*/
    $('#KsvmExtId').on('change', function () {
        var KsvmId = $('#KsvmExtId').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmInventarioAjax.php',
            data: {'KsvmIvtStkCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmStockReq').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /**Método para cargar Requisición*/
    $('#KsvmBdgReq').on('change', function () {
        var KsvmId = $('#KsvmBdgReq').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmRequisicionAjax.php',
            data: {'KsvmBdgCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmRqcId').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /**Método para cargar Medicamento*/
    $('#KsvmRqcId').on('change', function () {
        var KsvmId = $('#KsvmRqcId').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmRequisicionAjax.php',
            data: {'KsvmRqcCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmExtId').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
        /**Método para cargar Stock*/
        $('#KsvmExtId').on('change', function () {
        var KsvmId = $('#KsvmExtId').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmRequisicionAjax.php',
            data: {'KsvmRqcCantCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmCantTran').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /* Oculta secciones*/
    $("#GridData").hide();
    $('#btnGuardar').hide();
    $("#GridRowsInv").hide();
    $('#KsvmBdgExt').hide();
    /*Método para mostrar u ocultar botones*/
    $('#btnAgregar').on('click', function () {
        var KsvmDato1 = $('#KsvmBdgExt').val();
        var KsvmDato2 = $('#KsvmBdgInv').val();
        var KsvmDato3 = $('#KsvmBdgReq').val();
        var KsvmDato4 = $('#KsvmCodX').val();
        if ((KsvmDato1 != null && KsvmDato4 != "") || (KsvmDato2 != null && KsvmDato4 != "") || (KsvmDato3 != null && KsvmDato4 != "")) {
            $("#btnGuardar").show(500);
            $("#btnIniciar").hide(500);
            $("#leyenda").hide(500);
        }else{
            $("#btnGuardar").hide(500);
        }
    });
    /*Método para mostrar u ocultar formularios*/
    $('#btnGuardar').on('click', function () {
        $("#GridRows").hide(500);
        $("#GridRowsInv").hide(500);
        $('#KsvmBdgExt').hide(500);
        $("#KsvmBdgReq").hide(500);
        $("#KsvmRqcId").hide(500);
        $("#GridData").show(500);
    });

    $('#btnCancelar').on('click', function() {
        $("#GridData").hide(500);
        $("#GridRows").show(500);
        $("#GridRowsInv").show(500);
        $('#KsvmBdgExt').show(500);
        $("#KsvmBdgReq").show(500);
        $("#KsvmRqcId").show(500);
        $("#btnIniciar").hide(500);
        $("#leyenda").hide(500);
    });

    $('#btnIniciar').on('click', function() {
        $("#GridRowsInv").show(500);
        $('#KsvmBdgExt').show(500);
    });
    /**Métodos para cerrar modal */
    $('#btnExitOcp').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmCompras/1/";
    });
    $('#btnExitInv').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmInventarios/1/";
    });
    $('#btnExitReq').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmRequisiciones/1/";
    });
    $('#btnExitIng').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmIngresos/1/";
    });
    $('#btnExitEgr').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmEgresos/1/";
    });

});

</script>
