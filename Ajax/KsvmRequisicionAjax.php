<?php

/**
*Petición Ajax para registrar editar o eliminar una requisición
*/
$KsvmPeticionAjax = true;
require_once "../Raiz/KsvmConfiguracion.php";

if (isset($_POST['KsvmIvtId']) || isset($_POST['KsvmCodDelete']) || isset($_POST['KsvmCodEdit']) || isset($_POST['KsvmBdgCod'])
    || isset($_POST['KsvmRqcCod']) || isset($_POST['KsvmRqcCantCod']) || isset($_POST['KsvmCodX'])) {
    require_once "../Controladores/KsvmRequisicionControlador.php";
    $KsvmIniRequisicion = new KsvmRequisicionControlador();

    if (!isset($_POST['KsvmCodDelete']) && !isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmOrigenReq']) && isset($_POST['KsvmIvtId'])) {

          echo $KsvmIniRequisicion->__KsvmAgregarRequisicionControlador();
    }

    if (isset($_POST['KsvmCodDelete'])) {
        echo $KsvmIniRequisicion->__KsvmEliminarRequisicionControlador();
    }

    if (isset($_POST['KsvmCodX'])) {
        echo $KsvmIniRequisicion->__KsvmEliminarRegistroRequisicion();
    }

    if (isset($_POST['KsvmCodEdit']) && isset($_POST['KsvmCantReq'])) {
        echo $KsvmIniRequisicion->__KsvmActualizarRequisicionControlador();
    }

    if (isset($_POST['KsvmBdgCod'])) {
        echo $KsvmIniRequisicion->__KsvmSeleccionarRequisicion();
    }

    if (isset($_POST['KsvmRqcCod'])) {
        echo $KsvmIniRequisicion->__KsvmCargarMedicamento();
    }

    if (isset($_POST['KsvmRqcCantCod'])) {
        echo $KsvmIniRequisicion->__KsvmCargarCantidad();
    }
    
} else {
    session_start(['name' => 'SIGIM']);
    session_destroy();
    echo '<script> window.location.href=" '.KsvmServUrl.'Login"</script>';
}
