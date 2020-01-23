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
        var KsvmBod = $('#KsvmBdgInv').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmInventarioAjax.php',
            data: {'KsvmIvtStkCod': KsvmId, 'KsvmBod': KsvmBod}
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
        var KsvmTipo = $('#KsvmTipoTran').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmRequisicionAjax.php',
            data: {'KsvmBdgCod': KsvmId, 'KsvmTipo': KsvmTipo}
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
    /**Método para cargar tipo*/
    $('#KsvmTipoTran').on('change', function () {
        var KsvmId = $('#KsvmTipoTran').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmTransaccionAjax.php',
            data: {'KsvmTipoTranCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmTTran').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /**Método para cargar bodega*/
    $('#KsvmBdgReq').on('change', function () {
        var KsvmId = $('#KsvmBdgReq').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmTransaccionAjax.php',
            data: {'KsvmBodCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmBodIn').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /**Método para cargar bodega*/
    $('#KsvmBdgId').on('change', function () {
        var KsvmId = $('#KsvmBdgId').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmTransaccionAjax.php',
            data: {'KsvmBodCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmBodEg').html(CargaLista);
        })
        .fail(function () {
            alert('Ocurrió un error al cargar la lista');
        });
        }
    });
    /**Método para cargar bodega*/
    $('#KsvmBdgExt').on('change', function () {
        var KsvmId = $('#KsvmBdgExt').val()
        if (KsvmId != "") {
        $.ajax({
            type: 'POST',
            url: '<?php echo KsvmServUrl;?>Ajax/KsvmInventarioAjax.php',
            data: {'KsvmBodCod': KsvmId}
        })
        .done(function (CargaLista) {
            $('#KsvmNvoStock').html(CargaLista);
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
    $('#btnSave').on('click', function () {
        var KsvmDato2 = $('#KsvmExtId').val();
        var KsvmDato3 = $('#KsvmDato3').val();
        if (KsvmDato2 != null && KsvmDato3 != "") {
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
    $('#btnExitAle').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmAlertas/1/";
    });
    $('#btnExitAleCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmAlertasCrud/1/";
    });
    $('#btnExitBod').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmBodegas/1/";
    });
    $('#btnExitBodCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmBodegasCrud/1/";
    });
    $('#btnExitBduCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmBodegaXUsuarioCrud/1/";
    });
    $('#btnExitCarCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmCargosCrud/1/";
    });
    $('#btnExitCatCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmCategoriasCrud/1/";
    });
    $('#btnExitOcp').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmCompras/1/";
    });
    $('#btnExitOcpCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmComprasCrud/1/";
    });
    $('#btnExitOcpRep').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmReporteComprasGen/1/";
    });
    $('#btnExitEmp').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmEmpleados/1/";
    });
    $('#btnExitEmpCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmEmpleadosCrud/1/";
    });
    $('#btnExitExt').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmExistencias/1/";
    });
    $('#btnExitExtCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmExistenciasCrud/1/";
    });
    $('#btnExitMed').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmCatalogoMedicamentos/1/";
    });
    $('#btnExitMedCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmMedicamentosCrud/1/";
    });
    $('#btnExitInv').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmInventarios/1/";
    });
    $('#btnExitInvCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmInventariosCrud/1/";
    });
    $('#btnExitInvRep').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmReporteInventariosGen/1/";
    });
    $('#btnExitMenCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmMenuCrud/1/";
    });
    $('#btnExitPrivCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmMenuXRolCrud/1/";
    });
    $('#btnExitPar').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmParametros/1/";
    });
    $('#btnExitParCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmParametrosCrud/1/";
    });
    $('#btnExitProcCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmProcedenciaCrud/1/";
    });
    $('#btnExitProv').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmProveedores/1/";
    });
    $('#btnExitProvCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmProveedoresCrud/1/";
    });
    $('#btnExitReq').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmRequisiciones/1/";
    });
    $('#btnExitReqCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmRequisicionesCrud/1/";
    });
    $('#btnExitReqRep').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmReportePedidosGen/1/";
    });
    $('#btnExitRolCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmRolesCrud/1/";
    });
    $('#btnExitIng').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmIngresos/1/";
    });
    $('#btnExitEgr').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmEgresos/1/";
    });
    $('#btnExitTran').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmTransaccionesCrud/1/";
    });
    $('#btnExitTranRep').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmReporteTransaccionesGen/1/";
    });
    $('#btnExitUnMedCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmUnidadesMedicasCrud/1/";
    });
    $('#btnExitUsr').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmUsuarios/1/";
    });
    $('#btnExitUsrCrud').on('click', function () {
        window.location.href="<?php echo KsvmServUrl;?>KsvmUsuariosCrud/1/";
    });

});

</script>


